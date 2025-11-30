<?php

namespace Tests\Feature\Validation;

use Tests\TestCase;
use App\Models\User;
use App\Models\Coche;
use App\Models\MarcaCoche;
use App\Models\CarroceriaCoche;
use App\Models\Pais;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class AlquilerValidationTest extends TestCase
{
    protected $usuario;
    protected $cliente;
    protected $marca;
    protected $carroceria;
    protected $pais;
    protected $coche;

    protected function setUp(): void
    {
        parent::setUp();

        $this->usuario = User::factory()->create([
            'nombre' => 'Usuario Admin',
            'email' => 'admin@ebis.com',
            'telefono' => '600000001',
            'dni' => '12345678A',
            'rol' => 'superadmin',
            'password' => Hash::make('12345678'),
        ]);

        $this->cliente = User::factory()->create([
            'nombre' => 'Cliente',
            'email' => 'cliente@ebis.com',
            'telefono' => '600000002',
            'dni' => '12345678B',
            'rol' => 'cliente',
            'password' => Hash::make('12345678'),
        ]);

        $this->marca = MarcaCoche::factory()->create();
        $this->carroceria = CarroceriaCoche::factory()->create();
        $this->pais = Pais::factory()->create();
        $this->coche=Coche::factory()->create([
            'marca_id'=>$this->marca->id,
            'carroceria_id'=>$this->carroceria->id,
            'pais_id'=>$this->pais->id,
            'nPlazas'=>5,
            'costeDia'=>50
        ]);

        Sanctum::actingAs($this->usuario);
    }

    public function test_coche_id_es_obligatorio()
    {
        $this->postJson('/api/alquileres', [
            'cliente_id' => $this->cliente->id,
            'fecha_inicio' => '2025-01-01',
            'fecha_fin' => '2025-01-05',
        ])->assertJsonValidationErrors(['coche_id']);
    }

    public function test_coche_id_debe_existir()
    {
        $this->postJson('/api/alquileres', [
            'coche_id' => 999,
            'cliente_id' => $this->cliente->id,
            'fecha_inicio' => '2025-01-01',
            'fecha_fin' => '2025-01-05',
        ])->assertJsonValidationErrors(['coche_id']);
    }

    public function test_cliente_id_es_obligatorio_para_admin_y_superadmin()
    {
        $this->postJson('/api/alquileres', [
            'coche_id' => $this->coche->id,
            'fecha_inicio' => '2025-01-01',
            'fecha_fin' => '2025-01-05',
            'cliente_id'=>null,
        ])->assertStatus(422);
    }

    public function test_cliente_id_debe_existir()
    {
        $this->postJson('/api/alquileres', [
            'coche_id' => $this->coche->id,
            'cliente_id' => 999,
            'fecha_inicio' => '2025-01-01',
            'fecha_fin' => '2025-01-05',
        ])->assertJsonValidationErrors(['cliente_id']);
    }

    public function test_fecha_inicio_es_obligatoria()
    {
        $this->postJson('/api/alquileres', [
            'coche_id' => $this->coche->id,
            'cliente_id' => $this->cliente->id,
            'fecha_fin' => '2025-01-05',
        ])->assertJsonValidationErrors(['fecha_inicio']);
    }

    public function test_fecha_inicio_debe_ser_fecha_valida()
    {
        $this->postJson('/api/alquileres', [
            'coche_id' => $this->coche->id,
            'cliente_id' => $this->cliente->id,
            'fecha_inicio' => 'invalid-date',
            'fecha_fin' => '2025-01-05',
        ])->assertJsonValidationErrors(['fecha_inicio']);
    }

    public function test_fecha_fin_es_obligatoria()
    {
        $this->postJson('/api/alquileres', [
            'coche_id' => $this->coche->id,
            'cliente_id' => $this->cliente->id,
            'fecha_inicio' => '2025-01-01',
        ])->assertJsonValidationErrors(['fecha_fin']);
    }

    public function test_fecha_fin_debe_ser_fecha_valida()
    {
        $this->postJson('/api/alquileres', [
            'coche_id' => $this->coche->id,
            'cliente_id' => $this->cliente->id,
            'fecha_inicio' => '2025-01-01',
            'fecha_fin' => 'invalid-date',
        ])->assertJsonValidationErrors(['fecha_fin']);
    }

    public function test_fecha_fin_debe_ser_posterior_a_fecha_inicio()
    {
        $this->postJson('/api/alquileres', [
            'coche_id' => $this->coche->id,
            'cliente_id' => $this->cliente->id,
            'fecha_inicio' => '2025-01-05',
            'fecha_fin' => '2025-01-01',
        ])->assertJsonValidationErrors(['fecha_fin']);
    }
}
