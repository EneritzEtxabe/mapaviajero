<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Coche;
use App\Models\MarcaCoche;
use App\Models\CarroceriaCoche;
use App\Models\Pais;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class CocheCrudTest extends TestCase
{
    protected $marca;
    protected $carroceria;
    protected $pais;
    protected $coche;

    protected function setUp(): void
      {
            parent::setUp();

            $this->marca = MarcaCoche::factory()->create();
            $this->carroceria = CarroceriaCoche::factory()->create();
            $this->pais = Pais::factory()->create();
            $this->coche=Coche::factory()->create([
                  'marca_id' => $this->marca->id,
                  'carroceria_id' => $this->carroceria->id,
                  'pais_id' => $this->pais->id,
            ]);
      }

    protected function loginAsRole(string $rol): User
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_puede_listar_coches()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/coches')->assertStatus(200);
    }

    public function test_admin_puede_listar_coches()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/coches')->assertStatus(200);
    }

    public function test_superadmin_puede_listar_coches()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/coches')->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_listar_coches()
    {
        $this->getJson('/api/coches')->assertStatus(401);
    }

    public function test_cliente_no_puede_crear_coches()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'ano' => 2020,
            'nPlazas' => 5,
            'cambio' => 'automático',
            'estado' => 'disponible',
            'costeDia' => 55.00,
            'pais_id' => $this->pais->id
        ])->assertStatus(403);
    }

    public function test_admin_puede_crear_coches()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'ano' => 2020,
            'nPlazas' => 5,
            'cambio' => 'automático',
            'estado' => 'disponible',
            'costeDia' => 55.00,
            'pais_id' => $this->pais->id
        ])->assertStatus(201);
    }

    public function test_superadmin_puede_crear_coches()
    {
        $this->loginAsRole('superadmin');
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'ano' => 2020,
            'nPlazas' => 5,
            'cambio' => 'automático',
            'estado' => 'disponible',
            'costeDia' => 55.00,
            'pais_id' => $this->pais->id
        ])->assertStatus(201);
    }

    public function test_usuario_sin_token_no_puede_crear_coches()
    {
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'ano' => 2020,
            'nPlazas' => 5,
            'cambio' => 'automático',
            'estado' => 'disponible',
            'costeDia' => 55.00,
            'pais_id' => $this->pais->id
        ])->assertStatus(401);
    }

    public function test_cliente_no_puede_actualizar_coches()
    {
        $this->loginAsRole('cliente');
        $coche = Coche::factory()->create([
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'pais_id' => $this->pais->id
        ]);
        $this->putJson("/api/coches/{$coche->id}", ['costeDia' => 70.00])
             ->assertStatus(403);
    }

    public function test_admin_puede_actualizar_coches()
    {
        $this->loginAsRole('admin');
        $coche = Coche::factory()->create([
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'pais_id' => $this->pais->id
        ]);
        $this->putJson("/api/coches/{$coche->id}", ['costeDia' => 74.00])
             ->assertStatus(200);
    }

    public function test_superadmin_puede_actualizar_coches()
    {
        $this->loginAsRole('superadmin');
        $coche = Coche::factory()->create([
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'pais_id' => $this->pais->id
        ]);
        $this->putJson("/api/coches/{$coche->id}", ['costeDia' => 57.00])
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_actualizar_coches()
    {
        $coche = Coche::factory()->create([
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'pais_id' => $this->pais->id
        ]);
        $this->putJson("/api/coches/{$coche->id}", ['costeDia' => 60.00])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_eliminar_coches()
    {
        $this->loginAsRole('cliente');
        $coche = Coche::factory()->create([
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'pais_id' => $this->pais->id
        ]);
        $this->deleteJson("/api/coches/{$coche->id}")->assertStatus(403);
    }

    public function test_admin_puede_eliminar_coches()
    {
        $this->loginAsRole('admin');
        $coche = Coche::factory()->create([
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'pais_id' => $this->pais->id
        ]);
        $this->deleteJson("/api/coches/{$coche->id}")->assertStatus(200);
    }

    public function test_superadmin_puede_eliminar_coches()
    {
        $this->loginAsRole('superadmin');
        $coche = Coche::factory()->create([
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'pais_id' => $this->pais->id
        ]);
        $this->deleteJson("/api/coches/{$coche->id}")->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_coches()
    {
        $coche = Coche::factory()->create([
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'pais_id' => $this->pais->id
        ]);
        $this->deleteJson("/api/coches/{$coche->id}")->assertStatus(401);
    }
}

