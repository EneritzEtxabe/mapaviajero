<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Continente;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Continente>
 */
class ContinenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $continentes = [
        'Asia','África','Europa','Oceanía','Sudamérica','Norteamérica','Antártida'
        ];

        return [
            'nombre' => $this->faker->unique()->randomElement($continentes),
        ];
    }
}

