<?php
namespace Tests\Feature\Validation;

use Tests\TestCase;
use App\Models\Coche;
use App\Models\MarcaCoche;
use App\Models\CarroceriaCoche;
use App\Models\Pais;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class CocheValidationTest extends TestCase
{
    protected $usuario;
    protected $marca;
    protected $carroceria;
    protected $pais;

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

        $this->marca = MarcaCoche::factory()->create();
        $this->carroceria = CarroceriaCoche::factory()->create();
        $this->pais = Pais::factory()->create();
    }

    public function test_marca_id_es_obligatorio()
    {
        $this->postJson('/api/coches', [])
            ->assertJsonValidationErrors('marca_id');
    }

    public function test_marca_id_debe_existir()
    {
        $this->postJson('/api/coches', ['marca_id' => 999])
            ->assertJsonValidationErrors('marca_id');
    }

    public function test_carroceria_id_es_obligatorio()
    {
        $this->postJson('/api/coches', [])
            ->assertJsonValidationErrors('carroceria_id');
    }

    public function test_carroceria_id_debe_existir()
    {
        $this->postJson('/api/coches', ['carroceria_id' => 999])
            ->assertJsonValidationErrors('carroceria_id');
    }

    public function test_ano_debe_ser_entero_y_4_digitos()
    {
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 4,
            'costeDia' => 50,
            'pais_id' => $this->pais->id,
            'ano' => 'abcd'
        ])->assertJsonValidationErrors('ano');

        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 4,
            'costeDia' => 50,
            'pais_id' => $this->pais->id,
            'ano' => 123
        ])->assertJsonValidationErrors('ano');
    }

    public function test_nPlazas_es_obligatorio_y_valido()
    {
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'costeDia' => 50,
            'pais_id' => $this->pais->id
        ])->assertJsonValidationErrors('nPlazas');

        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 3,
            'costeDia' => 50,
            'pais_id' => $this->pais->id
        ])->assertJsonValidationErrors('nPlazas');
    }

    public function test_cambio_debe_ser_manual_o_automatico()
    {
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 4,
            'costeDia' => 50,
            'pais_id' => $this->pais->id,
            'cambio' => 'robotizado'
        ])->assertJsonValidationErrors('cambio');
    }

    public function test_estado_debe_ser_valido()
    {
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 4,
            'costeDia' => 50,
            'pais_id' => $this->pais->id,
            'estado' => 'vendido'
        ])->assertJsonValidationErrors('estado');
    }

    public function test_costeDia_es_obligatorio_y_valido()
    {
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 4,
            'pais_id' => $this->pais->id
        ])->assertJsonValidationErrors('costeDia');

        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 4,
            'costeDia' => 150,
            'pais_id' => $this->pais->id
        ])->assertJsonValidationErrors('costeDia');
    }

    public function test_pais_id_es_obligatorio_y_debe_existir()
    {
        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 4,
            'costeDia' => 50,
        ])->assertJsonValidationErrors('pais_id');

        $this->postJson('/api/coches', [
            'marca_id' => $this->marca->id,
            'carroceria_id' => $this->carroceria->id,
            'nPlazas' => 4,
            'costeDia' => 50,
            'pais_id' => 999
        ])->assertJsonValidationErrors('pais_id');
    }
}