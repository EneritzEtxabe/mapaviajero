<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Lugar;
use App\Models\Pais;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class LugarCrudTest extends TestCase
{
    protected $lugar;
    protected $pais;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pais = Pais::factory()->create(['nombre' => 'España']);
        $this->lugar = Lugar::factory()->create([
            'nombre' => 'Zumaia',
            'descripcion' => 'Ermita de San Telmo',
            'pais_id' => $this->pais->id,
            'imagen_url' => 'https://example.com/imagen.jpg',
            'web_url' => 'https://example.com',
            'localizacion_url' => 'https://maps.google.com',
        ]);
    }

    protected function loginAsRole(string $rol)
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_puede_listar_lugares()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/lugares')
             ->assertStatus(200);
    }

    public function test_admin_puede_listar_lugares()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/lugares')->assertStatus(200);
    }

    public function test_superadmin_puede_listar_lugares()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/lugares')->assertStatus(200);
    }

    public function test_usuario_sin_token_puede_listar_lugares()
    {
        $this->getJson('/api/lugares')->assertStatus(200);
    }

     public function test_cliente_no_puede_crear_lugares()
    {
          $this->loginAsRole('cliente');
          $this->postJson('/api/lugares', [
                    'nombre' => 'San Juan de Gaztelugatxe',
                    'descripcion' => 'En plena costa vasca...',
                    'pais_id'=>$this->pais->id,
                    'imagen_url' =>'https://turismo.euskadi.eus/contenidos/h_cultura_y_patrimonio/0000010461_h5_rec_turismo/es_10461/images/CT_13_Gaztelugatxe1.jpg',
                    'web_url' => 'https://turismo.euskadi.eus/es/san-juan-de-gaztelugatxe/webtur00-recursostop/es',
                    'localizacion_url' =>'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13864.696994992737!2d-2.7952997273883207!3d43.447014566365326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4e4003af0b451d%3A0xa03f81fdc5ea65be!2sGaztelugatxe!5e1!3m2!1ses!2ses!4v1764430111581!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade'
                ])
               ->assertStatus(403);
    }
    public function test_admin_puede_crear_lugares()
    {
          $this->loginAsRole('admin');
          $this->postJson('/api/lugares', [
                    'nombre' => 'San Juan de Gaztelugatxe',
                    'descripcion' => 'En plena costa vasca...',
                    'pais_id'=>$this->pais->id,
                    'imagen_url' =>'https://turismo.euskadi.eus/contenidos/h_cultura_y_patrimonio/0000010461_h5_rec_turismo/es_10461/images/CT_13_Gaztelugatxe1.jpg',
                    'web_url' => 'https://turismo.euskadi.eus/es/san-juan-de-gaztelugatxe/webtur00-recursostop/es',
                    'localizacion_url' =>'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13864.696994992737!2d-2.7952997273883207!3d43.447014566365326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4e4003af0b451d%3A0xa03f81fdc5ea65be!2sGaztelugatxe!5e1!3m2!1ses!2ses!4v1764430111581!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade'
                ])
               ->assertStatus(201);
    }
    public function test_superadmin_puede_crear_lugares()
    {
          $this->loginAsRole('superadmin');
          $this->postJson('/api/lugares', [
                    'nombre' => 'San Juan de Gaztelugatxe',
                    'descripcion' => 'En plena costa vasca...',
                    'pais_id'=>$this->pais->id,
                    'imagen_url' =>'https://turismo.euskadi.eus/contenidos/h_cultura_y_patrimonio/0000010461_h5_rec_turismo/es_10461/images/CT_13_Gaztelugatxe1.jpg',
                    'web_url' => 'https://turismo.euskadi.eus/es/san-juan-de-gaztelugatxe/webtur00-recursostop/es',
                    'localizacion_url' =>'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13864.696994992737!2d-2.7952997273883207!3d43.447014566365326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4e4003af0b451d%3A0xa03f81fdc5ea65be!2sGaztelugatxe!5e1!3m2!1ses!2ses!4v1764430111581!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade'
                ])
               ->assertStatus(201);
    }
    public function test_usuario_sin_token_no_puede_crear_lugares()
    {
        $this->postJson('/api/lugares', [
                    'nombre' => 'San Juan de Gaztelugatxe',
                    'descripcion' => 'En plena costa vasca...',
                    'pais_id'=>$this->pais->id,
                    'imagen_url' =>'https://turismo.euskadi.eus/contenidos/h_cultura_y_patrimonio/0000010461_h5_rec_turismo/es_10461/images/CT_13_Gaztelugatxe1.jpg',
                    'web_url' => 'https://turismo.euskadi.eus/es/san-juan-de-gaztelugatxe/webtur00-recursostop/es',
                    'localizacion_url' =>'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13864.696994992737!2d-2.7952997273883207!3d43.447014566365326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd4e4003af0b451d%3A0xa03f81fdc5ea65be!2sGaztelugatxe!5e1!3m2!1ses!2ses!4v1764430111581!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade'
                ])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_actualizar_lugares()
    {
        $this->loginAsRole('cliente');
        $this->putJson("/api/lugares/{$this->lugar->id}", ['nombre' => 'Lugar actualizado'])
             ->assertStatus(403);
    }

    public function test_admin_puede_actualizar_lugares()
    {
        $this->loginAsRole('admin');
        $this->putJson("/api/lugares/{$this->lugar->id}", ['nombre' => 'Lugar actualizado'])
             ->assertStatus(200);
    }

    public function test_superadmin_puede_actualizar_lugares()
    {
        $this->loginAsRole('superadmin');
        $this->putJson("/api/lugares/{$this->lugar->id}", ['nombre' => 'Lugar actualizado'])
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_actualizar_lugares()
    {
        $this->putJson("/api/lugares/{$this->lugar->id}", ['nombre' => 'Lugar actualizado'])
             ->assertStatus(401);
    }

    public function test_cliente_no_puede_eliminar_lugares()
    {
        $this->loginAsRole('cliente');
        $this->deleteJson("/api/lugares/{$this->lugar->id}")
             ->assertStatus(403);
    }

    public function test_admin_puede_eliminar_lugares()
    {
        $this->loginAsRole('admin');
        $this->deleteJson("/api/lugares/{$this->lugar->id}")
             ->assertStatus(200);
    }

    public function test_superadmin_puede_eliminar_lugares()
    {
        $this->loginAsRole('superadmin');
        $this->deleteJson("/api/lugares/{$this->lugar->id}")
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_lugares()
    {
        $this->deleteJson("/api/lugares/{$this->lugar->id}")
             ->assertStatus(401);
    }
}

