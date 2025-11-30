<?php

namespace Tests\Feature\Validation;

use Tests\TestCase;
use App\Models\MarcaCoche;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class MarcaCocheValidationTest extends TestCase
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
        $this->postJson('/api/marcaCoches', [])
            ->assertJsonValidationErrors('nombre');
    }

    public function test_nombre_debe_ser_string()
    {
        $this->postJson('/api/marcaCoches', [
            'nombre' => 12345
        ])
        ->assertJsonValidationErrors('nombre');
    }

    public function test_nombre_no_puede_repetirse()
    {
        MarcaCoche::factory()->create(['nombre' => 'Toyota']);

        $this->postJson('/api/marcaCoches', [
            'nombre' => 'Toyota'
        ])
        ->assertJsonValidationErrors('nombre');
    }
}