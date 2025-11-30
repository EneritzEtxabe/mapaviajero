<?php

namespace Tests\Feature\Validation;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class UserUpdateValidationTest extends TestCase
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

        User::factory()->create([
            'email' => 'existente@ebis.com',
            'telefono' => '600000002',
            'dni' => '12345678B',
            'rol' => 'cliente',
        ]);
    }

    public function test_email_no_puede_estar_repetido()
    {
        $response = $this->putJson("/api/users/{$this->usuario->id}", [
            'email' => 'existente@ebis.com',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    public function test_telefono_no_puede_estar_repetido()
    {
        $response = $this->putJson("/api/users/{$this->usuario->id}", [
            'telefono' => '600000002',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['telefono']);
    }

    public function test_dni_no_puede_estar_repetido()
    {
        $response = $this->putJson("/api/users/{$this->usuario->id}", [
            'dni' => '12345678B',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['dni']);
    }

    public function test_dni_debe_tener_formato_valido()
    {
        $response = $this->putJson("/api/users/{$this->usuario->id}", [
            'dni' => '123NOVALIDO',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['dni']);
    }

    public function test_rol_no_puede_ser_invalido()
    {
        $response = $this->putJson("/api/users/{$this->usuario->id}", [
            'rol' => 'administrador',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['rol']);
    }

    public function test_nombre_no_puede_ser_mas_largo_de_255_caracteres()
    {
        $response = $this->putJson("/api/users/{$this->usuario->id}", [
            'nombre' => str_repeat('a', 256),
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_password_no_puede_tener_menos_de_8_caracteres()
    {
        $response = $this->putJson("/api/users/{$this->usuario->id}", [
            'password' => '1234567',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    }

    public function test_campos_validos_actualizan_correctamente()
    {
        $otroUsuario = User::where('telefono', '=','600000002')->first();
        $response = $this->putJson("/api/users/{$otroUsuario->id}", [
            'nombre' => 'Usuario Modificado',
            'email' => 'nuevo@ebis.com',
            'telefono' => '600000003',
            'dni' => '87654321Z',
            'rol' => 'admin',
            'password' => 'nuevopassword',
        ]);

        $response->assertStatus(200);

        $otroUsuario->refresh();
        $this->assertEquals('Usuario Modificado', $otroUsuario->nombre);
        $this->assertEquals('nuevo@ebis.com', $otroUsuario->email);
        $this->assertEquals('600000003', $otroUsuario->telefono);
        $this->assertEquals('87654321Z', $otroUsuario->dni);
        $this->assertEquals('admin', $otroUsuario->rol);
        $this->assertTrue(Hash::check('nuevopassword', $otroUsuario->password));
    }
}

