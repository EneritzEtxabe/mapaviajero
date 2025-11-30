<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pais;
use App\Models\Continente;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class PaisCrudTest extends TestCase
{
    protected $pais;

    protected function setUp(): void
    {
        parent::setUp();

        $continente = Continente::factory()->create(['nombre' => 'Europa']);
        $this->pais = Pais::factory()->create([
            'nombre' => 'España',
            'continente_id' => $continente->id,
            'capital' => 'Madrid',
            'bandera_url' => 'https://example.com/bandera.png',
            'conduccion' => 'derecha'
        ]);
    }

    protected function loginAsRole(string $rol)
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_puede_listar_paises()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/paises')->assertStatus(200);
    }

    public function test_admin_puede_listar_paises()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/paises')->assertStatus(200);
    }

    public function test_superadmin_puede_listar_paises()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/paises')->assertStatus(200);
    }

    public function test_usuario_sin_token_puede_listar_paises()
    {
        $this->getJson('/api/paises')->assertStatus(200);
    }

    public function test_cliente_no_puede_crear_paises()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/paises', [
            'nombre' => 'Francia',
            'continente_id' => $this->pais->continente_id,
            'capital' => 'París',
            'bandera_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ42rZRjiYg12snbp_nk6OG7mRfC4zD8N9uLg&s',
            'conduccion' => 'izquierda'
        ])->assertStatus(403);
    }

    public function test_admin_puede_crear_paises()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/paises', [
            'nombre' => 'Francia',
            'continente_id' => $this->pais->continente_id,
            'capital' => 'París',
            'bandera_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ42rZRjiYg12snbp_nk6OG7mRfC4zD8N9uLg&s',
            'conduccion' => 'izquierda'
        ])->assertStatus(201);
    }

    public function test_superadmin_puede_crear_paises()
    {
        $this->loginAsRole('superadmin');
        $this->postJson('/api/paises', [
            'nombre' => 'Italia',
            'continente_id' => $this->pais->continente_id,
            'capital' => 'Roma',
            'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/0/03/Flag_of_Italy.svg',
            'conduccion' => 'derecha'
        ])->assertStatus(201);
    }

    public function test_usuario_sin_token_no_puede_crear_paises()
    {
        $this->postJson('/api/paises', [
            'nombre' => 'Alemania',
            'continente_id' => $this->pais->continente_id,
            'capital' => 'Berlín',
            'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/0/03/Flag_of_Italy.svg',
            'conduccion' => 'derecha'
        ])->assertStatus(401);
    }

    public function test_cliente_no_puede_actualizar_paises()
    {
        $this->loginAsRole('cliente');
        $this->putJson("/api/paises/{$this->pais->id}", ['nombre' => 'España Actualizada'])
             ->assertStatus(403);
    }

    public function test_admin_puede_actualizar_paises()
    {
        $this->loginAsRole('admin');
        $this->putJson("/api/paises/{$this->pais->id}", ['nombre' => 'España Actualizada'])
             ->assertStatus(200);
    }

    public function test_superadmin_puede_actualizar_paises()
    {
        $this->loginAsRole('superadmin');
        $this->putJson("/api/paises/{$this->pais->id}", ['nombre' => 'España Actualizada'])
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_actualizar_paises()
    {
        $this->putJson("/api/paises/{$this->pais->id}", ['nombre' => 'España Actualizada'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_eliminar_paises()
    {
        $this->loginAsRole('cliente');
        $this->deleteJson("/api/paises/{$this->pais->id}")
             ->assertStatus(403);
    }

    public function test_admin_puede_eliminar_paises()
    {
        $this->loginAsRole('admin');
        $this->deleteJson("/api/paises/{$this->pais->id}")
             ->assertStatus(200);
    }

    public function test_superadmin_puede_eliminar_paises()
    {
        $this->loginAsRole('superadmin');
        $this->deleteJson("/api/paises/{$this->pais->id}")
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_paises()
    {
        $this->deleteJson("/api/paises/{$this->pais->id}")
             ->assertStatus(401);
    }
}
