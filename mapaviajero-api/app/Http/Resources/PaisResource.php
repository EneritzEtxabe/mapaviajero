<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Pais",
 *     type="object",
 *     title="Pais (Recurso API)",
 *     description="Respuesta de la API para un país, con relaciones y campos amigables",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Argentina"),
 *     @OA\Property(property="bandera_url", type="string", format="url", nullable=true, example="https://example.com/bandera.png"),
 *     @OA\Property(property="capital", type="string", example="Buenos Aires"),
 *     @OA\Property(
 *         property="continente",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=3),
 *         @OA\Property(property="nombre", type="string", example="Europa")
 *     ),
 *     @OA\Property(property="conduccion", type="string", enum={"izquierda","derecha"}, nullable=true, example="izquierda"),
 *     @OA\Property(
 *         property="idiomas",
 *         type="array",
 *         description="Idiomas hablados en el país",
 *         @OA\Items(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=1),
 *              @OA\Property(property="nombre", type="string", example="Español")
 *         )
 *     ),
 *     @OA\Property(
 *         property="lugares",
 *         type="array",
 *         description="Lugares turísticos del país",
 *         @OA\Items(
 *              type="object",
 *              @OA\Property(property="id", type="integer", example=5),
 *              @OA\Property(property="nombre", type="string", example="Cataratas del Iguazú")
 *          )
 *     ),
 * )
 */
class PaisResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $this->loadMissing(['idiomas','continente','lugares']);

        $resultado =[
            'id' => $this->id,
            'nombre' => $this->nombre,
            'bandera_url'=>$this->bandera_url,
            'capital'=>$this->capital,
            'continente' =>[
                'id'=>$this->continente->id,
                'nombre'=>$this->continente->nombre
            ],
            'conduccion'=>$this->conduccion,
            'idiomas' => $this->idiomas->map(function ($idioma) {
                return [
                    'id' => $idioma->id,
                    'nombre' => $idioma->nombre,
                ];
            }),
            'lugares' => $this->lugares->map(function ($lugar) {
                return [
                    'id' => $lugar->id,
                    'nombre' => $lugar->nombre,
                ];
            }),
        ];
        return $resultado;
    }
}
