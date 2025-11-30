<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Idioma;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class IdiomaCrudTest extends TestCase
{

    protected $idioma;

    protected function setUp(): void
    {
        parent::setUp();

        $this->idioma = Idioma::factory()->create([
            'iso_639_1' => 'en',
            'nombre' => 'Inglés',
        ]);
    }

    protected function loginAsRole(string $rol)
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_puede_listar_idiomas()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/idiomas')
             ->assertStatus(200);
    }

    public function test_admin_puede_listar_idiomas()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/idiomas')
             ->assertStatus(200);
    }

    public function test_superadmin_puede_listar_idiomas()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/idiomas')
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_listar_idiomas()
    {
        $this->getJson('/api/idiomas')->assertStatus(401);
    }

    public function test_cliente_no_puede_crear_idiomas()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/idiomas', [
                'iso_639_1' => 'pt',
                'nombre' => 'Portugués'
            ])
             ->assertStatus(403);
    }

    public function test_admin_puede_crear_idiomas()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/idiomas', [
                'iso_639_1' => 'pt',
                'nombre' => 'Portugués'
            ])
             ->assertStatus(201);
    }

    public function test_superadmin_puede_crear_idiomas()
    {
        $this->loginAsRole('superadmin');
        $this->postJson('/api/idiomas', [
                'iso_639_1' => 'ja',
                'nombre' => 'Japonés'
            ])
             ->assertStatus(201);
    }

    public function test_usuario_sin_token_no_puede_crear_idiomas()
    {
        $this->postJson('/api/idiomas', [
                'iso_639_1' => 'pt',
                'nombre' => 'Portugués'
            ])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_actualizar_idiomas()
    {
        $this->loginAsRole('cliente');
        $this->putJson("/api/idiomas/{$this->idioma->id}", ['nombre' => 'Ruso'])
             ->assertStatus(403);
    }

    public function test_admin_puede_actualizar_idiomas()
    {
        $this->loginAsRole('admin');
        $this->putJson("/api/idiomas/{$this->idioma->id}", ['nombre' => 'Ruso'])
             ->assertStatus(200);
    }

    public function test_superadmin_puede_actualizar_idiomas()
    {
        $this->loginAsRole('superadmin');
        $this->putJson("/api/idiomas/{$this->idioma->id}", ['nombre' => 'Gallego'])
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_actualizar_idiomas()
    {
        $this->putJson("/api/idiomas/{$this->idioma->id}", ['nombre' => 'Gallego'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_eliminar_idiomas()
    {
        $this->loginAsRole('cliente');
        $this->deleteJson("/api/idiomas/{$this->idioma->id}")
             ->assertStatus(403);
    }

    public function test_admin_puede_eliminar_idiomas()
    {
        $this->loginAsRole('admin');
        $this->deleteJson("/api/idiomas/{$this->idioma->id}")
             ->assertStatus(200);
    }

    public function test_superadmin_puede_eliminar_idiomas()
    {
        $this->loginAsRole('superadmin');
        $this->deleteJson("/api/idiomas/{$this->idioma->id}")
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_idiomas()
    {
        $this->deleteJson("/api/idiomas/{$this->idioma->id}")
             ->assertStatus(401);
    }
}
