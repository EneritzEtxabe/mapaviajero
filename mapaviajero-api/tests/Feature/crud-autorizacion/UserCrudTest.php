<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class UserCrudTest extends TestCase
{
    protected function loginAsRole(string $rol)
    {
        $user = User::factory()->create(['rol' => $rol]);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_cliente_no_puede_listar_usuarios()
    {
        $this->loginAsRole('cliente');
        $this->getJson('/api/users')
             ->assertStatus(403);
    }

    public function test_admin_puede_listar_usuarios()
    {
        $this->loginAsRole('admin');
        $this->getJson('/api/users')
             ->assertStatus(200);
    }

    public function test_superadmin_puede_listar_usuarios()
    {
        $this->loginAsRole('superadmin');
        $this->getJson('/api/users')
             ->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_listar_usuarios()
    {
        $this->getJson('/api/users')
             ->assertStatus(401);
    }

    public function test_cliente_puede_crear_usuarios_cliente()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/users', [
                    'nombre' => 'Cliente4',
                    'email' => 'cliente4@ebis.com',
                    'telefono' =>'677578769',
                    'dni'=>'88587721R',
                    'rol' => 'cliente',
                    'password' => Hash::make('12345678'),
             ])
             ->assertStatus(201);
    }

    public function test_cliente_no_puede_crear_usuarios_admin()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/users', [
                    'nombre' => 'Admin7',
                    'email' => 'admin7@ebis.com',
                    'telefono' =>'678888769',
                    'dni'=>'88587991R',
                    'rol' => 'admin',
                    'password' => Hash::make('12345678'),
             ])
             ->assertStatus(403);
    }

    public function test_cliente_no_puede_crear_usuarios_superadmin()
    {
        $this->loginAsRole('cliente');
        $this->postJson('/api/users', [
                    'nombre' => 'Superadmin7',
                    'email' => 'superadmin7@ebis.com',
                    'telefono' =>'678844769',
                    'dni'=>'88587991R',
                    'rol' => 'superadmin',
                    'password' => Hash::make('12345678'),
             ])
             ->assertStatus(403);
    }

    public function test_admin_puede_crear_usuarios_cliente()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/users', [
                    'nombre' => 'Cliente4',
                    'email' => 'cliente4@ebis.com',
                    'telefono' =>'677578769',
                    'dni'=>'88587721R',
                    'rol' => 'cliente',
                    'password' => Hash::make('12345678'),
             ])
             ->assertStatus(201);
    }

    public function test_admin_no_puede_crear_usuarios_admin()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/users', [
                    'nombre' => 'admin2',
                    'email' => 'admin2@ebis.com',
                    'telefono' =>'677778769',
                    'dni'=>'87587721R',
                    'rol' => 'admin',
                    'password' => Hash::make('12345678'),
             ])
             ->assertStatus(403);
    }

    public function test_admin_no_puede_crear_usuarios_superadmin()
    {
        $this->loginAsRole('admin');
        $this->postJson('/api/users', [
                    'nombre' => 'superadmin2',
                    'email' => 'superadmin2@ebis.com',
                    'telefono' =>'677778749',
                    'dni'=>'87587787R',
                    'rol' => 'superadmin',
                    'password' => Hash::make('12345678'),
             ])
             ->assertStatus(403);
    }

    public function test_superadmin_puede_crear_usuarios()
    {
        $this->loginAsRole('superadmin');
        $this->postJson('/api/users', [
                    'nombre' => 'superadmin3',
                    'email' => 'superadmin3@ebis.com',
                    'telefono' =>'677478749',
                    'dni'=>'87777787R',
                    'rol' => 'superadmin',
                    'password' => Hash::make('12345678'),
             ])
             ->assertStatus(201);
    }

    public function test_usuario_sin_token_puede_crear_usuarios_cliente()
    {
        $this->postJson('/api/users', [
                'nombre' => 'cliente5',
                'email' => 'cliente5@ebis.com',
                'telefono' =>'677485449',
                'dni'=>'87458787R',
                'rol' => 'cliente',
                'password' => Hash::make('12345678'),
             ])
             ->assertStatus(201);
    }

    public function test_usuario_sin_token_no_puede_crear_usuarios_admin()
    {
        $this->postJson('/api/users', [
                'nombre' => 'admin3',
                'email' => 'admin3@ebis.com',
                'telefono' =>'674445449',
                'dni'=>'87458787R',
                'rol' => 'admin',
                'password' => Hash::make('12345678'),
             ])
             ->assertStatus(403);
    }

    public function test_usuario_sin_token_no_puede_crear_usuarios_superadmin()
    {
        $this->postJson('/api/users', [
                'nombre' => 'superadmin3',
                'email' => 'superadmin3@ebis.com',
                'telefono' =>'671145449',
                'dni'=>'87455787R',
                'rol' => 'superadmin',
                'password' => Hash::make('12345678'),
             ])
             ->assertStatus(403);
    }

    public function test_cliente_puede_actualizar_datos_propios()
    {
        $cliente = $this->loginAsRole('cliente');
        $this->putJson("/api/users/{$cliente->id}", [
            'email' => 'nuevoemail@cliente.com',
            'telefono' => '600111222'
        ])->assertStatus(200);
    }

    public function test_cliente_no_puede_actualizar_datos_ajenos()
    {
        $cliente = $this->loginAsRole('cliente');
        $otro = User::factory()->create(['rol'=>'cliente']);
        $this->putJson("/api/users/{$otro->id}", [
            'email' => 'maria@cliente.com',
            'telefono' =>'677445449',
        ])->assertStatus(403);
    }

    public function test_cliente_no_puede_actualizar_su_rol()
    {
        $cliente = $this->loginAsRole('cliente');
        $this->putJson("/api/users/{$cliente->id}", ['rol'=>'admin'])->assertStatus(200);
        $cliente->refresh();
        $this->assertEquals('cliente', $cliente->rol);
    }

    public function test_admin_puede_actualizar_datos_cliente()
    {
        $this->loginAsRole('admin');
        $cliente = User::factory()->create(['rol'=>'cliente']);
        $this->putJson("/api/users/{$cliente->id}",     ['email'=>'nuevoemail@ebis.com',
        'telefono' =>'677477449',])
             ->assertStatus(200);
    }
    public function test_admin_puede_actualizar_datos_propios()
    {
          $user=$this->loginAsRole('admin');
          $this->putJson("/api/users/{$user->id}", [
                    'email' => 'mariaa@ebis.com',
                    'telefono' =>'677775449',
                ])
               ->assertStatus(200);
    }
    public function test_admin_no_puede_actualizar_datos_superadmin()
    {
          $this->loginAsRole('admin');
          $otrosuperadmin = User::factory()->create(['rol'=>'superadmin']);
          $this->putJson("/api/users/{$otrosuperadmin->id}", [
                    'email' => 'mariia@ebis.com',
                    'telefono' =>'677345449',
                ])
               ->assertStatus(403);
    }
    public function test_admin_no_puede_actualizar_rol()
    {
          $user=$this->loginAsRole('admin');
          
          $this->putJson("/api/users/{$user->id}", [
                    'rol' => 'superadmin'
          ]);
          $user->refresh();
          $this->assertEquals('admin',$user->rol);
    }
    public function test_superadmin_puede_actualizar_datos_propios()
    {
          $user=$this->loginAsRole('superadmin');
          $this->putJson("/api/users/{$user->id}", [
                    'nombre' => 'superadmin3',
                    'email' => 'superadmin3@ebis.com',
                    'telefono' =>'671145449',
                    'dni'=>'87455787R',
                    'rol' => 'admin',
                    'password' => Hash::make('12345678'),
                ])
               ->assertStatus(200);
    }
    public function test_superadmin_puede_actualizar_datos_ajenos()
    {
          $this->loginAsRole('superadmin');
          $otroadmin = User::factory()->create(['rol'=>'admin']);
          $this->putJson("/api/users/{$otroadmin->id}", [
                    'nombre' => 'superadmin4',
                    'email' => 'superadmin4@ebis.com',
                    'telefono' =>'671145449',
                    'dni'=>'87455787R',
                    'rol' => 'superadmin',
                    'password' => Hash::make('12345678'),
                ])
               ->assertStatus(200);
    }
    public function test_usuario_sin_token_no_puede_actualizar_datos()
    {
        $cliente = User::factory()->create(['rol'=>'cliente']);
        $this->putJson("/api/users/{$cliente->id}", [
                    'password' => Hash::make('123456789'),
             ])
             ->assertStatus(401);
    }

    public function test_cliente_puede_eliminar_usuario_propio()
    {
        $cliente = $this->loginAsRole('cliente');
        $this->deleteJson("/api/users/{$cliente->id}")->assertStatus(200);
    }
    public function test_cliente_no_puede_eliminar_usuarios_ajenos()
    {
          $cliente = $this->loginAsRole('cliente');
          $otroCliente = User::factory()->create(['rol'=>'cliente']);
          $this->deleteJson("/api/users/{$otroCliente->id}")
               ->assertStatus(403);
    }

    public function test_admin_puede_eliminar_clientes()
    {
        $this->loginAsRole('admin');
        $cliente = User::factory()->create(['rol'=>'cliente']);
        $this->deleteJson("/api/users/{$cliente->id}")->assertStatus(200);
    }
    public function test_admin_puede_eliminar_su_usuario()
    {
          $admin=$this->loginAsRole('admin');
          $this->deleteJson("/api/users/{$admin->id}")
               ->assertStatus(200);
    }
     public function test_admin_no_puede_eliminar_admins()
    {
          $this->loginAsRole('admin');
          $otroAdmin = User::factory()->create(['rol'=>'admin']);
          $this->deleteJson("/api/users/{$otroAdmin->id}")
               ->assertStatus(403);
    }
    public function test_admin_no_puede_eliminar_superadmin()
    {
          $this->loginAsRole('admin');
          $otroSuperAdmin = User::factory()->create(['rol'=>'superadmin']);
          $this->deleteJson("/api/users/{$otroSuperAdmin->id}")
               ->assertStatus(403);
    }
    public function test_superadmin_puede_eliminar_cualquier_usuario()
    {
        $this->loginAsRole('superadmin');
        $admin = User::factory()->create(['rol'=>'admin']);
        $this->deleteJson("/api/users/{$admin->id}")->assertStatus(200);
    }

    public function test_usuario_sin_token_no_puede_eliminar_usuarios()
    {
        $cliente = User::factory()->create(['rol'=>'cliente']);
        $this->deleteJson("/api/users/{$cliente->id}")->assertStatus(401);
    }
}
