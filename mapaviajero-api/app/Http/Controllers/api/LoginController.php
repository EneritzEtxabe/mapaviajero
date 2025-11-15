<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Login"},
     *     summary="Login de usuario",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@ebis.com"),
     *             @OA\Property(property="password", type="string", format="password", example="secret")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token generado",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciales incorrectas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Credenciales incorrectas")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=429,
     *         description="Demasiados intentos fallidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Demasiados intentos fallidos. Inténtalo más tarde")
     *         )
     *     )
     * )
     */
    public function login(LoginRequest $request): JsonResponse{
        $request ->authenticate();
        $user = $request->user();
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['token'=>$token, 'message'=>'Login exitoso. Utilice este Token en el header: Authorization: Bearer'], 200);
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Logout"},
     *     summary="Logout de usuario",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sesión cerrada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado o token inválido"
     *     )
     * )
     */
    public function logout(Request $request):JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'La sesión se ha cerrado correctamente']);
    }
}
