<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\TipoLugar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TipoLugarValidationTest extends TestCase
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
        $response = $this->postJson('/api/tipoLugares', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_debe_ser_string()
    {
        $response = $this->postJson('/api/tipoLugares', [
            'nombre' => 12345,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_debe_tener_al_menos_3_caracteres()
    {
        $response = $this->postJson('/api/tipoLugares', [
            'nombre' => 'ab',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_no_puede_estar_repetido()
    {
        TipoLugar::factory()->create([
            'nombre' => 'Aventura'
        ]);

        $response = $this->postJson('/api/tipoLugares', [
            'nombre' => 'Aventura',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_tipo_lugar_se_crea_correctamente_con_datos_validos()
    {
        $response = $this->postJson('/api/tipoLugares', [
            'nombre' => 'Montaña',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tipo_lugares', [
            'nombre' => 'Montaña',
        ]);
    }
}

