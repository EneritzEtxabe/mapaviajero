<?php

namespace Tests\Feature\Validation;

use Tests\TestCase;
use App\Models\Pais;
use App\Models\Lugar;
use App\Models\TipoLugar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class LugarValidationTest extends TestCase
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
    }
    public function test_nombre_es_obligatorio()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'pais_id' => $pais->id
        ])
        ->assertJsonValidationErrors('nombre');
    }

    public function test_nombre_debe_ser_string()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => 123,
            'pais_id' => $pais->id
        ])
        ->assertJsonValidationErrors('nombre');
    }

    public function test_nombre_no_puede_repetirse()
    {
        Lugar::factory()->create(['nombre' => 'Lugar Test']);

        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test',
            'pais_id' => $pais->id
        ])
        ->assertJsonValidationErrors('nombre');
    }

    public function test_nombre_no_puede_superar_255_caracteres()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => str_repeat('a', 256),
            'pais_id' => $pais->id
        ])
        ->assertJsonValidationErrors('nombre');
    }

    public function test_pais_id_es_obligatorio()
    {
        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test'
        ])
        ->assertJsonValidationErrors('pais_id');
    }

    public function test_pais_id_debe_existir()
    {
        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test',
            'pais_id' => 99999
        ])
        ->assertJsonValidationErrors('pais_id');
    }

    public function test_descripcion_debe_ser_string()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test',
            'pais_id' => $pais->id,
            'descripcion' => 12345
        ])
        ->assertJsonValidationErrors('descripcion');
    }

    public function test_imagen_url_debe_ser_url_valida()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test',
            'pais_id' => $pais->id,
            'imagen_url' => 'no-es-url'
        ])
        ->assertJsonValidationErrors('imagen_url');
    }

    public function test_web_url_debe_ser_valida()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test',
            'pais_id' => $pais->id,
            'web_url' => 'xxx'
        ])
        ->assertJsonValidationErrors('web_url');
    }

    public function test_localizacion_url_debe_ser_http_valida()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test',
            'pais_id' => $pais->id,
            'localizacion_url' => 'ftp://mal'
        ])
        ->assertJsonValidationErrors('localizacion_url');
    }

    public function test_tipoLugares_debe_ser_array()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test',
            'pais_id' => $pais->id,
            'tipoLugares' => 'cadena'
        ])
        ->assertJsonValidationErrors('tipoLugares');
    }

    public function test_tipoLugares_deben_existir()
    {
        $pais = Pais::factory()->create();

        $this->postJson('/api/lugares', [
            'nombre' => 'Lugar Test',
            'pais_id' => $pais->id,
            'tipoLugares' => [9999]
        ])
        ->assertJsonValidationErrors('tipoLugares.0');
    }
}
