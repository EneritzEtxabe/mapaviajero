<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TipoLugar;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class TipoLugarCrudTest extends TestCase
{
    protected $tipoLugar;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tipoLugar = TipoLugar::factory()->create([
            'nombre' => 'Parque'
        ]);
    }

    protected function loginAsRole(string $rol)
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_puede_listar_tipoLugares()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/tipoLugares')
             ->assertStatus(200);
    }

    public function test_admin_puede_listar_tipoLugares()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/tipoLugares')->assertStatus(200);
    }

    public function test_superadmin_puede_listar_tipoLugares()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/tipoLugares')->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_listar_tipoLugares()
    {
        $this->getJson('/api/tipoLugares')->assertStatus(401);
    }

    public function test_cliente_no_puede_crear_tipoLugares()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/tipoLugares', ['nombre' => 'Fiesta'])
             ->assertStatus(403);
    }

    public function test_admin_puede_crear_tipoLugares()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/tipoLugares', ['nombre' => 'Festival'])
             ->assertStatus(201);
    }

    public function test_superadmin_puede_crear_tipoLugares()
    {
        $this->loginAsRole('superadmin');
        $this->postJson('/api/tipoLugares', ['nombre' => 'Evento'])
             ->assertStatus(201);
    }

    public function test_usuario_sin_token_no_puede_crear_tipoLugares()
    {
        $this->postJson('/api/tipoLugares', ['nombre' => 'Fiesta'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_actualizar_tipoLugares()
    {
        $this->loginAsRole('cliente');
        $this->putJson("/api/tipoLugares/{$this->tipoLugar->id}", ['nombre' => 'Parque Actualizado'])
             ->assertStatus(403);
    }

    public function test_admin_puede_actualizar_tipoLugares()
    {
        $this->loginAsRole('admin');
        $this->putJson("/api/tipoLugares/{$this->tipoLugar->id}", ['nombre' => 'Parque Actualizado'])
             ->assertStatus(200);
    }

    public function test_superadmin_puede_actualizar_tipoLugares()
    {
        $this->loginAsRole('superadmin');
        $this->putJson("/api/tipoLugares/{$this->tipoLugar->id}", ['nombre' => 'Parque Actualizado'])
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_actualizar_tipoLugares()
    {
        $this->putJson("/api/tipoLugares/{$this->tipoLugar->id}", ['nombre' => 'Parque Actualizado'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_eliminar_tipoLugares()
    {
        $this->loginAsRole('cliente');
        $this->deleteJson("/api/tipoLugares/{$this->tipoLugar->id}")
             ->assertStatus(403);
    }

    public function test_admin_puede_eliminar_tipoLugares()
    {
        $this->loginAsRole('admin');
        $this->deleteJson("/api/tipoLugares/{$this->tipoLugar->id}")
             ->assertStatus(200);
    }

    public function test_superadmin_puede_eliminar_tipoLugares()
    {
        $this->loginAsRole('superadmin');
        $this->deleteJson("/api/tipoLugares/{$this->tipoLugar->id}")
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_tipoLugares()
    {
        $this->deleteJson("/api/tipoLugares/{$this->tipoLugar->id}")
             ->assertStatus(401);
    }
}