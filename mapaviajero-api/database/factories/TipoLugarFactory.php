<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipoLugar;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipoLugar>
 */
class TipoLugarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipos = [
            'Naturaleza','Deporte','Aventura','Parques temáticos','Salud y Bienestar',
            'Gastronomía','Cultura','Montaña','Playa','Rural','Ciudad'
        ];

        return [
            'nombre' => $this->faker->unique()->randomElement($tipos),
        ];
    }
}

