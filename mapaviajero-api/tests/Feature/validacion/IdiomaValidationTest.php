<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Idioma;
use Laravel\Sanctum\Sanctum;

class IdiomaValidationTest extends TestCase
{
    protected $usuario;

    protected function setUp(): void
    {
        parent::setUp();

        $this->usuario = User::factory()->create([
            'nombre' => 'Usuario Original',
            'email' => 'original@ebis.com',
            'telefono' => '600000001',
            'dni' => '12345678A',
            'rol' => 'superadmin',
            'password' => Hash::make('12345678'),
        ]);
        Sanctum::actingAs($this->usuario);
    }

    public function test_nombre_es_obligatorio()
    {
        $response = $this->postJson('/api/idiomas', [
            'iso_639_1' => 'es',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_debe_ser_string()
    {
        $response = $this->postJson('/api/idiomas', [
            'nombre' => 12345,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_debe_tener_al_menos_3_caracteres()
    {
        $response = $this->postJson('/api/idiomas', [
            'nombre' => 'ab',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_no_puede_estar_repetido()
    {
        Idioma::factory()->create([
            'nombre' => 'Inglés'
        ]);

        $response = $this->postJson('/api/idiomas', [
            'nombre' => 'Inglés',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_iso_639_1_debe_tener_2_caracteres()
    {
        $response = $this->postJson('/api/idiomas', [
            'nombre' => 'Francés',
            'iso_639_1' => 'fra',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['iso_639_1']);
    }

    public function test_iso_639_1_no_puede_estar_repetido()
    {
        Idioma::factory()->create([
            'nombre' => 'Euskera',
            'iso_639_1' => 'eu'
        ]);

        $response = $this->postJson('/api/idiomas', [
            'nombre' => 'Otro',
            'iso_639_1' => 'eu',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['iso_639_1']);
    }

    public function test_idioma_se_crea_correctamente_con_datos_validos()
    {
        $response = $this->postJson('/api/idiomas', [
            'nombre' => 'Japonés',
            'iso_639_1' => 'ja',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('idiomas', [
            'nombre' => 'Japonés',
            'iso_639_1' => 'ja',
        ]);
    }
}

