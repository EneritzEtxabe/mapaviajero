<?php

namespace Tests\Feature\Validation;

use Tests\TestCase;
use App\Models\User;

class UserStoreValidationTest extends TestCase
{
    public function test_nombre_es_obligatorio()
    {
        $this->postJson('/api/users', [
            'email' => 'test@ebis.com',
            'password' => '12345678',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('nombre');
    }

    public function test_nombre_no_puede_superar_255_caracteres()
    {
        $this->postJson('/api/users', [
            'nombre' => str_repeat('a', 256),
            'email' => 'test@ebis.com',
            'password' => '12345678',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('nombre');
    }

    public function test_email_es_obligatorio()
    {
        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'password' => '12345678',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('email');
    }

    public function test_email_debe_tener_formato_valido()
    {
        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'no-es-un-email',
            'password' => '12345678',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('email');
    }

    public function test_email_debe_ser_unico()
    {
        User::factory()->create(['email' => 'existe@ebis.com']);

        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'existe@ebis.com',
            'password' => '12345678',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('email');
    }

    public function test_password_es_obligatorio()
    {
        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'test@ebis.com',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('password');
    }

    public function test_password_debe_tener_minimo_8_caracteres()
    {
        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'test@ebis.com',
            'password' => '123',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('password');
    }

    public function test_telefono_debe_ser_numerico_si_se_envia()
    {
        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'test@ebis.com',
            'password' => '12345678',
            'telefono' => 'abc123',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('telefono');
    }

    public function test_telefono_debe_tener_9_digitos()
    {
        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'test@ebis.com',
            'password' => '12345678',
            'telefono' => '12345',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('telefono');
    }

    public function test_telefono_debe_ser_unico()
    {
        User::factory()->create(['telefono' => '612345678']);

        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'nuevo@ebis.com',
            'password' => '12345678',
            'telefono' => '612345678',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('telefono');
    }

    public function test_dni_debe_tener_formato_valido_si_se_envia()
    {
        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'test@ebis.com',
            'password' => '12345678',
            'dni' => 'ABC123',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('dni');
    }

    public function test_dni_debe_ser_unico()
    {
        User::factory()->create(['dni' => '12345678A']);

        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'nuevo@ebis.com',
            'password' => '12345678',
            'dni' => '12345678A',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('dni');
    }

    public function test_rol_debe_ser_valido_si_se_envia()
    {
        $this->postJson('/api/users', [
            'nombre' => 'Juan',
            'email' => 'test@ebis.com',
            'password' => '12345678',
            'rol' => 'administrador',
        ])->assertStatus(422)
          ->assertJsonValidationErrors('rol');
    }
}
