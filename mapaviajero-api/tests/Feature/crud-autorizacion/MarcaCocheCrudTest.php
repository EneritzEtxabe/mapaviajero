<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\MarcaCoche;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class MarcaCocheCrudTest extends TestCase
{
    protected $marca;

    protected function setUp(): void
    {
        parent::setUp();

        $this->marca = MarcaCoche::factory()->create([
            'nombre' => 'Toyota'
        ]);
    }

    protected function loginAsRole(string $rol)
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_puede_listar_marcas()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/marcaCoches')
             ->assertStatus(200);
    }

    public function test_admin_puede_listar_marcas()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/marcaCoches')->assertStatus(200);
    }

    public function test_superadmin_puede_listar_marcas()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/marcaCoches')->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_listar_marcas()
    {
        $this->getJson('/api/marcaCoches')->assertStatus(401);
    }

    public function test_cliente_no_puede_crear_marcas()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/marcaCoches', ['nombre' => 'Seat'])
             ->assertStatus(403);
    }

    public function test_admin_puede_crear_marcas()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/marcaCoches', ['nombre' => 'Seat'])
             ->assertStatus(201);
    }

    public function test_superadmin_puede_crear_marcas()
    {
        $this->loginAsRole('superadmin');
        $this->postJson('/api/marcaCoches', ['nombre' => 'Ferrari'])
             ->assertStatus(201);
    }

    public function test_usuario_sin_token_no_puede_crear_marcas()
    {
        $this->postJson('/api/marcaCoches', ['nombre' => 'Opel'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_actualizar_marcas()
    {
        $this->loginAsRole('cliente');
        $this->putJson("/api/marcaCoches/{$this->marca->id}", ['nombre' => 'Lamborghini'])
             ->assertStatus(403);
    }

    public function test_admin_puede_actualizar_marcas()
    {
        $this->loginAsRole('admin');
        $this->putJson("/api/marcaCoches/{$this->marca->id}", ['nombre' => 'Lamborghini'])
             ->assertStatus(200);
    }

    public function test_superadmin_puede_actualizar_marcas()
    {
        $this->loginAsRole('superadmin');
        $this->putJson("/api/marcaCoches/{$this->marca->id}", ['nombre' => 'Ferrari'])
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_actualizar_marcas()
    {
        $this->putJson("/api/marcaCoches/{$this->marca->id}", ['nombre' => 'Ferrari'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_eliminar_marcas()
    {
        $this->loginAsRole('cliente');
        $this->deleteJson("/api/marcaCoches/{$this->marca->id}")
             ->assertStatus(403);
    }

    public function test_admin_puede_eliminar_marcas()
    {
        $this->loginAsRole('admin');
        $this->deleteJson("/api/marcaCoches/{$this->marca->id}")
             ->assertStatus(200);
    }

    public function test_superadmin_puede_eliminar_marcas()
    {
        $this->loginAsRole('superadmin');
        $this->deleteJson("/api/marcaCoches/{$this->marca->id}")
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_marcas()
    {
        $this->deleteJson("/api/marcaCoches/{$this->marca->id}")
             ->assertStatus(401);
    }
}

