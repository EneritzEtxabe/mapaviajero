<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CarroceriaCoche;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class CarroceriaCocheCrudTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        CarroceriaCoche::factory()->count(3)->create();
    }
    protected function loginAsRole(string $rol)
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_puede_listar_carrocerias()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/carroceriaCoches')
             ->assertStatus(200);
    }

    public function test_admin_puede_listar_carrocerias()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/carroceriaCoches')
             ->assertStatus(200);
    }

    public function test_superadmin_puede_listar_carrocerias()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/carroceriaCoches')
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_listar_carrocerias()
    {
        $this->getJson('/api/carroceriaCoches')->assertStatus(401);
    }

    public function test_cliente_no_puede_crear_carrocerias()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/carroceriaCoches', ['nombre' => 'SUV'])
             ->assertStatus(403);
    }

    public function test_admin_puede_crear_carrocerias()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/carroceriaCoches', ['nombre' => 'Deportivo'])
             ->assertStatus(201);
    }

    public function test_superadmin_puede_crear_carrocerias()
    {
        $this->loginAsRole('superadmin');
        $this->postJson('/api/carroceriaCoches', ['nombre' => 'Todoterreno'])
             ->assertStatus(201);
    }

    public function test_usuario_sin_token_no_puede_crear_carrocerias()
    {
        $this->postJson('/api/carroceriaCoches', ['nombre' => 'SUV'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_actualizar_carrocerias()
    {
        $this->loginAsRole('cliente');
        $carroceria = CarroceriaCoche::factory()->create();
        $this->putJson("/api/carroceriaCoches/{$carroceria->id}", ['nombre' => 'Sedan actualizado'])
             ->assertStatus(403);
    }

    public function test_admin_puede_actualizar_carrocerias()
    {
        $this->loginAsRole('admin');
        $carroceria = CarroceriaCoche::factory()->create();
        $this->putJson("/api/carroceriaCoches/{$carroceria->id}", ['nombre' => 'Sedan actualizado'])
             ->assertStatus(200);
    }

    public function test_superadmin_puede_actualizar_carrocerias()
    {
        $this->loginAsRole('superadmin');
        $carroceria = CarroceriaCoche::factory()->create();
        $this->putJson("/api/carroceriaCoches/{$carroceria->id}", ['nombre' => 'Sedan actualizado'])
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_actualizar_carrocerias()
    {
        $carroceria = CarroceriaCoche::factory()->create();
        $this->putJson("/api/carroceriaCoches/{$carroceria->id}", ['nombre' => 'Sedan actualizado'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_eliminar_carrocerias()
    {
        $this->loginAsRole('cliente');
        $carroceria = CarroceriaCoche::factory()->create();
        $this->deleteJson("/api/carroceriaCoches/{$carroceria->id}")
             ->assertStatus(403);
    }

    public function test_admin_puede_eliminar_carrocerias()
    {
        $this->loginAsRole('admin');
        $carroceria = CarroceriaCoche::factory()->create();
        $this->deleteJson("/api/carroceriaCoches/{$carroceria->id}")
             ->assertStatus(200);
    }

    public function test_superadmin_puede_eliminar_carrocerias()
    {
        $this->loginAsRole('superadmin');
        $carroceria = CarroceriaCoche::factory()->create();
        $this->deleteJson("/api/carroceriaCoches/{$carroceria->id}")
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_carrocerias()
    {
        $carroceria = CarroceriaCoche::factory()->create();
        $this->deleteJson("/api/carroceriaCoches/{$carroceria->id}")
             ->assertStatus(401);
    }
}

