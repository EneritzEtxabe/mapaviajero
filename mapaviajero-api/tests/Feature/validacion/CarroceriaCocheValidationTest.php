<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CarroceriaCoche;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarroceriaCocheValidationTest extends TestCase
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
        $response = $this->postJson('/api/carroceriaCoches', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_debe_ser_string()
    {
        $response = $this->postJson('/api/carroceriaCoches', [
            'nombre' => 1234,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_no_puede_estar_repetido()
    {
        CarroceriaCoche::factory()->create([
            'nombre' => 'SUV'
        ]);

        $response = $this->postJson('/api/carroceriaCoches', [
            'nombre' => 'SUV',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_carroceria_se_crea_correctamente_con_datos_validos()
    {
        $response = $this->postJson('/api/carroceriaCoches', [
            'nombre' => 'Coupé',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('carroceria_coches', [
            'nombre' => 'Coupé',
        ]);
    }
}

