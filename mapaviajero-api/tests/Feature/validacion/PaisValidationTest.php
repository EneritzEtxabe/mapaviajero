<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pais;
use App\Models\Continente;
use App\Models\Idioma;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaisValidationTest extends TestCase
{
    private $continente;
    protected $usuario;

    protected function setUp(): void
    {
        parent::setUp();

        // Necesario para las validaciones de foreign key
        $this->continente = Continente::factory()->create();
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
        $response = $this->postJson('/api/paises', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_no_puede_estar_repetido()
    {
        Pais::factory()->create(['nombre' => 'España']);

        $response = $this->postJson('/api/paises', [
            'nombre' => 'España',
            'continente_id' => $this->continente->id,
            'capital' => 'Madrid',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_nombre_debe_ser_string()
    {
        $response = $this->postJson('/api/paises', [
            'nombre' => 123,
            'continente_id' => $this->continente->id,
            'capital' => 'Madrid',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    public function test_continente_es_obligatorio()
    {
        $response = $this->postJson('/api/paises', [
            'nombre' => 'Chile',
            'capital' => 'Santiago',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['continente_id']);
    }

    public function test_continente_debe_existir()
    {
        $response = $this->postJson('/api/paises', [
            'nombre' => 'Chile',
            'capital' => 'Santiago',
            'continente_id' => 9999, // No existe
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['continente_id']);
    }

    public function test_capital_es_obligatoria()
    {
        $response = $this->postJson('/api/paises', [
            'nombre' => 'Argentina',
            'continente_id' => $this->continente->id,
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['capital']);
    }

    public function test_capital_no_puede_estar_repetida()
    {
        Pais::factory()->create(['capital' => 'Roma']);

        $response = $this->postJson('/api/paises', [
            'nombre' => 'Italia',
            'continente_id' => $this->continente->id,
            'capital' => 'Roma',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['capital']);
    }

    public function test_bandera_url_debe_ser_url_valida()
    {
        $response = $this->postJson('/api/paises', [
            'nombre' => 'Japón',
            'continente_id' => $this->continente->id,
            'capital' => 'Tokio',
            'bandera_url' => 'esto-no-es-una-url',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['bandera_url']);
    }

    public function test_bandera_url_no_puede_estar_repetida()
    {
        Pais::factory()->create(['bandera_url' => 'https://example.com/bandera.png']);

        $response = $this->postJson('/api/paises', [
            'nombre' => 'México',
            'continente_id' => $this->continente->id,
            'capital' => 'Ciudad de México',
            'bandera_url' => 'https://example.com/bandera.png',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['bandera_url']);
    }

    public function test_conduccion_debe_ser_izquierda_o_derecha()
    {
        $response = $this->postJson('/api/paises', [
            'nombre' => 'Australia',
            'continente_id' => $this->continente->id,
            'capital' => 'Canberra',
            'conduccion' => 'centro',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['conduccion']);
    }

    public function test_idiomas_debe_ser_array()
    {
        $response = $this->postJson('/api/paises', [
            'nombre' => 'Brasil',
            'continente_id' => $this->continente->id,
            'capital' => 'Brasilia',
            'idiomas' => 'portugues', // incorrecto
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['idiomas']);
    }

    public function test_idiomas_deben_existir()
    {
        $response = $this->postJson('/api/paises', [
            'nombre' => 'Brasil',
            'continente_id' => $this->continente->id,
            'capital' => 'Brasilia',
            'idiomas' => [999],
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['idiomas.0']);
    }

    public function test_pais_se_crea_correctamente_con_datos_validos()
    {
        $idioma = Idioma::factory()->create();

        $response = $this->postJson('/api/paises', [
            'nombre' => 'Perú',
            'continente_id' => $this->continente->id,
            'capital' => 'Lima',
            'bandera_url' => 'https://example.com/peru.png',
            'conduccion' => 'derecha',
            'idiomas' => [$idioma->id],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('paises', [
            'nombre' => 'Perú',
            'capital' => 'Lima',
        ]);
    }
}

