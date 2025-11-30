<?php

namespace Tests\Feature;

use App\Models\Alquiler;
use App\Models\User;
use App\Models\MarcaCoche;
use App\Models\CarroceriaCoche;
use App\Models\Pais;
use App\Models\Coche;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class AlquilerCrudTest extends TestCase
{
    protected $cliente;
    protected $admin;
    protected $superadmin;
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
            'marca_id'=>$this->marca->id,
            'carroceria_id'=>$this->carroceria->id,
            'pais_id'=>$this->pais->id,
            'estado' => 'disponible',
            'nPlazas'=>5,
            'costeDia'=>50
        ]);
    }

    protected function loginAsRole(string $rol)
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_no_puede_listar_alquileres()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/alquileres')->assertStatus(403);
    }

    public function test_admin_puede_listar_alquileres()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/alquileres')->assertStatus(200);
    }

    public function test_superadmin_puede_listar_alquileres()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/alquileres')->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_listar_alquileres()
    {
        $this->getJson('/api/alquileres')->assertStatus(401);
    }

    public function test_cliente_puede_crear_alquileres_propios()
    {
        $cliente = $this->loginAsRole('cliente');
        $this->postJson('/api/alquileres', [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
            'coche_id' => $this->coche->id,
            'cliente_id' => $cliente->id,
        ])->assertStatus(201);
    }

    public function test_cliente_no_puede_crear_alquileres_ajenos()
    {
        $this->loginAsRole('cliente');
        $otroCliente = User::factory()->create(['rol' => 'cliente']);
        $this->postJson('/api/alquileres', [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
            'coche_id' => $this->coche->id,
            'cliente_id' => $otroCliente->id,
        ])->assertStatus(403);
    }

    public function test_admin_puede_crear_alquileres()
    {
        $this->loginAsRole('admin');
        $otroCliente = User::factory()->create(['rol' => 'cliente']);

        $this->postJson('/api/alquileres', [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
            'coche_id' => $this->coche->id,
            'cliente_id' => $otroCliente->id,
        ])->assertStatus(201);
    }

    public function test_superadmin_puede_crear_alquileres()
    {
        $this->loginAsRole('superadmin');
        $otroCliente = User::factory()->create(['rol' => 'cliente']);

        $this->postJson('/api/alquileres', [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
            'coche_id' => $this->coche->id,
            'cliente_id' => $otroCliente->id,
        ])->assertStatus(201);
    }

    public function test_usuario_sin_token_no_puede_crear_alquileres()
    {
        $otroCliente = User::factory()->create(['rol' => 'cliente']);

        $this->postJson('/api/alquileres', [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
            'coche_id' => $this->coche->id,
            'cliente_id' => $otroCliente->id,
        ])->assertStatus(401);
    }

    public function test_cliente_puede_actualizar_alquileres_propios()
    {
        $cliente=$this->loginAsRole('cliente');
        $alquiler = Alquiler::factory()->create([
            'cliente_id' => $cliente->id,
            'coche_id' => $this->coche->id,
            'fecha_inicio' => '2025-12-01',
            'fecha_fin' => '2025-12-05',
        ]);

        $this->putJson("/api/alquileres/{$alquiler->id}", [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
        ])->assertStatus(200);
    }

    public function test_cliente_no_puede_actualizar_alquileres_ajenos()
    {
        $this->loginAsRole('cliente');
        $otroCliente = User::factory()->create(['rol' => 'cliente']);
        $alquiler = Alquiler::factory()->create([
            'cliente_id' => $otroCliente->id,
            'coche_id' => $this->coche->id,
            'fecha_inicio' => '2025-12-01',
            'fecha_fin' => '2025-12-05',
        ]);

        $this->putJson("/api/alquileres/{$alquiler->id}", [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
        ])->assertStatus(403);
    }

    public function test_admin_puede_actualizar_alquileres()
    {
        $this->loginAsRole('admin');
        $alquiler = Alquiler::factory()->create(['coche_id' => $this->coche->id]);
        $this->putJson("/api/alquileres/{$alquiler->id}", [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
        ])->assertStatus(200);
    }

    public function test_superadmin_puede_actualizar_alquileres()
    {
        $this->loginAsRole('superadmin');
        $alquiler = Alquiler::factory()->create(['coche_id' => $this->coche->id]);
        $this->putJson("/api/alquileres/{$alquiler->id}", [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
        ])->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_actualizar_alquileres()
    {
        $alquiler = Alquiler::factory()->create(['coche_id' => $this->coche->id]);
        $this->putJson("/api/alquileres/{$alquiler->id}", [
            'fecha_inicio' => '2025-12-12',
            'fecha_fin' => '2025-12-25',
        ])->assertStatus(401);
    }

    public function test_cliente_puede_eliminar_alquileres_propios()
    {
        $cliente=$this->loginAsRole('cliente');
        $alquiler = Alquiler::factory()->create([
            'cliente_id' => $cliente->id,
            'coche_id' => $this->coche->id,
        ]);

        $this->deleteJson("/api/alquileres/{$alquiler->id}")->assertStatus(200);
    }

    public function test_cliente_no_puede_eliminar_alquileres_ajenos()
    {
        $this->loginAsRole('cliente');
        $otroCliente = User::factory()->create(['rol' => 'cliente']);
        $alquiler = Alquiler::factory()->create([
            'cliente_id' => $otroCliente->id,
            'coche_id' => $this->coche->id,
        ]);

        $this->deleteJson("/api/alquileres/{$alquiler->id}")->assertStatus(403);
    }

    public function test_admin_puede_eliminar_alquileres()
    {
        $this->loginAsRole('admin');
        $alquiler = Alquiler::factory()->create(['coche_id' => $this->coche->id]);

        $this->deleteJson("/api/alquileres/{$alquiler->id}")->assertStatus(200);
    }

    public function test_superadmin_puede_eliminar_alquileres()
    {
        $this->loginAsRole('superadmin');
        $alquiler = Alquiler::factory()->create(['coche_id' => $this->coche->id]);

        $this->deleteJson("/api/alquileres/{$alquiler->id}")->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_alquileres()
    {
        $alquiler = Alquiler::factory()->create(['coche_id' => $this->coche->id]);
        $this->deleteJson("/api/alquileres/{$alquiler->id}")->assertStatus(401);
    }
}
