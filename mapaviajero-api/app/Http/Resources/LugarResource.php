<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Lugar",
 *     title="Lugar (Recurso API)",
 *     description="Respuesta de la API para un lugar turístico",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="nombre", type="string", example="Cataratas del Iguazú"),
 *     @OA\Property(
 *         property="pais",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="nombre", type="string",               example="Albania")
 *     ),
 *     @OA\Property(
 *         property="continente",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=3),
 *         @OA\Property(property="nombre", type="string", example="Europa")
 * ),
 *     @OA\Property(property="descripcion", type="string", nullable=true, example="Impresionante sistema de cascadas en la frontera de Argentina y Brasil."),
 *     @OA\Property(property="imagen_url", type="string", format="url", nullable=true, example="https://example.com/iguazu.jpg"),
 *     @OA\Property(property="web_url", type="string", format="url", nullable=true, example="https://turismo.argentina.gob.ar/iguazu"),
 *     @OA\Property(property="localizacion_url", type="string", format="url", nullable=true, example="https://share.google/uDfwaJERSuf3sAtya"),
 *     @OA\Property(
 *         property="tipoLugares",
 *         type="array",
 *         description="Tipos de lugar (ej: playa, montaña...)",
 *         @OA\Items(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="nombre", type="string", example="Cultura")
 *          )
 *     ),
 * )
 */

class LugarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing(['pais','tipoLugares']);

        $resultado =[
            'id' => $this->id,
            'nombre' => $this->nombre,
            'pais' =>[
                'id'=>$this->pais->id,
                'nombre'=>$this->pais->nombre
            ],
            'continente'=>[
                'id'=>$this->pais->continente->id,
                'nombre'=>$this->pais->continente->nombre,
            ],
            'descripcion'=>$this->descripcion,
            'imagen_url'=>$this->imagen_url,
            'web_url' => $this->web_url,
            'localizacion_url' => $this->localizacion_url,
            'tipo_lugar' => $this->tipoLugares->map(function ($tipoLugar) {
                return [
                    'id' => $tipoLugar->id,
                    'nombre' => $tipoLugar->nombre,
                ];
            }),
        ];
        return $resultado;
    }
}
