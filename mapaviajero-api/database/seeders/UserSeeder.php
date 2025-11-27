<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nombre' => 'SuperAdmin',
            'email' => 'superadmin@ebis.com',
            'telefono' =>'685468258',
            'dni'=>'78884921A',
            'rol' => 'superadmin',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'nombre' => 'Admin',
            'email' => 'admin@ebis.com',
            'telefono' =>'684452258',
            'dni'=>'75824921A',
            'rol' => 'admin',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'nombre' => 'Cliente1',
            'email' => 'cliente1@ebis.com',
            'telefono' =>'684585769',
            'dni'=>'74587521R',
            'rol' => 'cliente',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'nombre' => 'Cliente2',
            'email' => 'cliente2@ebis.com',
            'telefono' =>'688587769',
            'dni'=>'74588821R',
            'rol' => 'cliente',
            'password' => Hash::make('12345678'),
        ]);
        User::create([
            'nombre' => 'Cliente3',
            'email' => 'cliente3@ebis.com',
            'telefono' =>'677585769',
            'dni'=>'88587521R',
            'rol' => 'cliente',
            'password' => Hash::make('12345678'),
        ]);
    }
}
