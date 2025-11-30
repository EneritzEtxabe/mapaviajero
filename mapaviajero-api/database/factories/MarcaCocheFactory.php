<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MarcaCoche;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MarcaCoche>
 */
class MarcaCocheFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->randomElement(['Toyota','Volkswagen','BMW','Ford','Audi','Kia','Peugeot','Hyundai','Renault','Nissan']),
        ];
    }
}

