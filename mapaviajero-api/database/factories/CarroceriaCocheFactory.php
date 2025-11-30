<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CarroceriaCoche;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CarroceriaCoche>
 */
class CarroceriaCocheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->randomElement([
                'Sedán', 'Familiar', 'Cupé', 'SUV', 'Monovolumen', 'Pick-up', 'Descapotable'
            ]),
        ];
    }
}



