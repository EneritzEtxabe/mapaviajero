<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Idioma;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idioma>
 */
class IdiomaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idiomas = [
            'en' => 'Inglés',
            'eu' => 'Euskera',
            'ar' => 'Árabe',
            'es' => 'Castellano',
            'fr' => 'Francés',
            'de' => 'Alemán',
            'zh' => 'Chino',
            'ca' => 'Catalán',
        ];

        $iso = $this->faker->unique()->randomElement(array_keys($idiomas));

        return [
            'iso_639_1' => $iso,
            'nombre' => $idiomas[$iso],
        ];
    }
}
