<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Laravel\Sanctum\PersonalAccessToken;

use App\Models\User;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Listar todos los usuarios",
     *     description="Obtiene la lista de todas usuarios disponibles. Solo accesible para administradores y superadministradores",
     *     tags={"Usuarios"},
     *     security={{"sanctum": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="total", type="integer", example=10),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acceso denegado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Solo los administradores pueden ver todos los usuarios")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        if(Gate::denies('es-admin') && Gate::denies('es-superadmin')){
            return response()->json(['message'=>'Solo los administradores pueden ver todos los usuarios'], 403);
        };

        $usuarios = User::get();
        $resultado = UserResource::collection($usuarios);
        return response()->json([
            'status' => 'success',
            'total' => $resultado->count(),
            'data' => $resultado
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crear un nuevo usuario",
     *     description="Accesible tanto para usuarios registrados como como no registrados. Permite crear y añadir un nuevo usuario a la Base de Datos. Solo se le permite al superadministrador asignar un rol de admin a un nuevo usuario.",
     *     operationId="storeUser",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos para crear un usuario",
     *         @OA\JsonContent(ref="#/components/schemas/UserDB")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado para crear usuarios con rol admin o superadmin",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Solo el superadministrador puede crear otro  usuario con el rol de administrador")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación"
     *     )
     * )
     */
    public function store(UserStoreRequest $request):JsonResponse
    {
        $data = $request->validated();

        $token = $request->bearerToken();

        if ($token) {
            $accessToken = PersonalAccessToken::findToken($token);
            if ($accessToken) {
                $user = $accessToken->tokenable;
                Auth::login($user);
            }
        }

        if (isset($data['rol']) && in_array($data['rol'],['admin','superadmin'])){
            if(!Auth::check() || Gate::denies('es-superadmin')){
                return response()->json(['message'=>'Solo el superadministrador puede crear otro usuario con el rol de administrador'], 403);
            }
        }

        $data['rol'] = $data['rol'] ?? 'cliente';

        $usuario = User::create($data);
        
        $resultado = new UserResource($usuario);
        return response()->json([
            'status' => 'success',
            'data' => $resultado,
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Mostrar información de un usuario específico (por id)",
     *     description="Obtiene los detalles de un usuario por su ID. Solo accesible para administradores, superadministradores y el propio usuario registrado.",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Acceso denegado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Solo el administrador o el propio cliente puede ver los datos de un usuario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(['message'=>'Usuario no encontrado'], 404);
        }

        if(Gate::denies('es-admin')&& Gate::denies('es-superadmin') && Gate::denies('es-creador-usuario',$user)){
            return response()->json(['message'=>'Solo el administrador o el propio cliente puede ver los datos de un usuario'], 403);
        }

        $resultado = new UserResource($user);
        return response()->json([
            'status' => 'success',
            'data' => $resultado
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Actualiza los datos de un usuario",              
     *     description="Permite modificar los datos de un usuario. Solo el superadministrador puede modificar roles.
     *                  Los permisos dependen del rol del usuario a modificar:
     *                      - cliente: admin, superadmin o propio usuario
     *                      - admin: superadmin o propio admin
     *                      - superadmin: solo el propio superadmin",
     *     operationId="updateUsuario",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a modificar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos para actualizar el usuario. El campo 'rol' solo se tendrá en cuenta si el usuarioa autenticado es superadministrador",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string", maxLength=255, description="Nombre del usuario", example="Juan Perez"),
     *             @OA\Property(property="email", type="string", format="email", description="Correo electrónico único", example="juan@ebis.com"),
     *             @OA\Property(property="password", type="string", format="password", minLength=8, description="Contraseña", example="secret"),
     *             @OA\Property(property="telefono", type="string", pattern="^\d{9}$", description="Teléfono (9 dígitos)", example="698457218"),
     *             @OA\Property(property="dni", type="string", pattern="^\d{8}[A-HJ-NP-TV-Z]$", description="DNI válido", example="45728152T"),
     *             @OA\Property(property="rol", type="string", enum={"superadmin","admin","cliente"}, description="Rol del usuario (solo superadmin puede modificarlo, será ignorado para otros roles)", example="cliente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Permiso denegado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Solo el superadministrador puede modificar el rol")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El correo electrónico no tiene un formato válido.")
     *         )
     *     )
     * )
     */
    public function update(UserUpdateRequest $request, string $id):JsonResponse
    {
        $usuario = User::find($id);

        if(!$usuario){
            return response()->json(['message'=>'Usuario no encontrado'], 404);
        }

        if(Gate::denies('es-superadmin')){
            $request->request->remove('rol'); 
        }

        switch ($usuario->rol){
            case "cliente":
                if(Gate::denies('es-admin') && Gate::denies('es-superadmin') && Gate::denies('es-creador-usuario',$usuario)){
                    return response()->json(['message'=>'Solo el administrador o el propio usuario puede editar sus datos'], 403);
                }
                break;
            case "admin":
                if(Gate::denies('es-superadmin') && Gate::denies('es-creador-usuario',$usuario)){
                    return response()->json(['message'=>'Solo el superadministrador o el propio administrador puede editar sus datos'], 403);
                }
                break;
            case "superadmin":
                if(Gate::denies('es-creador-usuario',$usuario)){
                    return response()->json(['message'=>'Solo el superadministrador puede editar sus datos'], 403);
                }
                break;
        }
    
        $data = $request->validated();
    
        if (isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        $usuario->update($data);

        $resultado = new UserResource($usuario);

        return response()->json([
            'status' => 'success',
            'data' => $resultado
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Eliminar un usuario",
     *     description="Permite eliminar un usuario registrado. Solo accesible para superadministradores, administradores (si el usuario a eliminar tiene el rol de cliente o es él mismo) y el propio usuario.",
     *     tags={"Usuarios"},
     *     security={{"sanctum":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario a eliminar",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Usuario borrado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario borrado correctamente")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="No autorizado para eliminar este usuario",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Solo los administradores o el propio usuario pueden eliminar un cliente")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $usuario = User::find($id);
        if(!$usuario){
            return response()->json(['message'=>'Usuario no encontrado'], 404);
        }
        if ($usuario->rol === "cliente"){
            if(Gate::denies('es-superadmin') && Gate::denies('es-admin') && Gate::denies('es-creador-usuario',$usuario)){
                return response()->json(['message'=>'Solo los administradores o el propio usuario pueden eliminar un cliente'], 403);
            };
        }else{
            if(Gate::denies('es-superadmin') && Gate::denies('es-creador-usuario',$usuario)){
                return response()->json(['message'=>'Solo el superadministrador o el propio administrador puede eliminar un usuario con rol de administrador'], 403);
            };
        }

        $usuario->delete();

        return response()->json(['message'=>'Usuario borrado correctamente'], 200);
    }
}
