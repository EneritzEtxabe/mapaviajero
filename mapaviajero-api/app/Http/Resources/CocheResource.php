<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Coche",
 *     type="object",
 *     title="Coche (Rescurso API)",
 *     description="Representación de un coche con detalles de marca, carrocería, país y alquileres",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *         description="ID único del coche"
 *     ),
 *     @OA\Property(
 *         property="marca",
 *         type="object",
 *         description="Detalles de la marca del coche",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nombre", type="string", example="Toyota")
 *     ),
 *     @OA\Property(
 *         property="carroceria",
 *         type="object",
 *         description="Detalles de la carroceria del coche",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nombre", type="string", example="Sedán")
 *     ),
 *     @OA\Property(
 *         property="ano",
 *         type="integer",
 *         example=2020,
 *         description="Año del coche"
 *     ),
 *     @OA\Property(
 *         property="nPlazas",
 *         type="integer",
 *         example=5,
 *         description="Número de plazas"
 *     ),
 *     @OA\Property(
 *         property="cambio",
 *         type="string",
 *         example="Manual",
 *         description="Tipo de cambio de marchas"
 *     ),
 *     @OA\Property(
 *         property="estado",
 *         type="string",
 *         example="Disponible",
 *         description="Estado del coche"
 *     ),
 *     @OA\Property(
 *         property="costeDia",
 *         type="number",
 *         format="float",
 *         example=35.5,
 *         description="Coste por día de alquiler"
 *     ),
 *     @OA\Property(
 *         property="pais",
 *         type="object",
 *         description="Detalles del país del coche",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nombre", type="string", example="España")
 *     ),
 *     @OA\Property(
 *         property="alquileres",
 *         type="array",
 *         description="Lista de alquileres de este coche",
 *         @OA\Items(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="fecha_inicio", type="string", example="2023-07-01"),
 *              @OA\Property(property="fecha_FIN", type="string", example="2023-07-10")
 *         )
 *     ),
 * )
 */
class CocheResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing(['marca','carroceria','pais','alquileres']);

        $resultado =[
            'id' => $this->id,
            'marca' =>[
                'id'=>$this->marca->id,
                'nombre'=>$this->marca->nombre
            ],
            'carroceria' =>[
                'id'=>$this->carroceria->id,
                'nombre'=>$this->carroceria->nombre
            ],
            'ano'=>$this->ano,
            'nPlazas' => $this->nPlazas,
            'cambio'=>$this->cambio,
            'estado' => $this->estado,
            'costeDia' => $this->costeDia,
            'pais' =>[
                'id'=>$this->pais->id,
                'nombre'=>$this->pais->nombre
            ],
            'alquileres' => $this->alquileres->map(function ($alquiler) {
                return [
                    'id' => $alquiler->id,
                    'fecha_inicio' => $alquiler->fecha_inicio,
                    'fecha_fin' => $alquiler->fecha_fin
                ];
            }),
        ];

        return $resultado;
    }
}
