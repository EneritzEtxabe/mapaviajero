<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Coche;
use App\Models\Alquiler;

use Database\Seeders\UserSeeder;
use Database\Seeders\ContinenteSeeder;
use Database\Seeders\TipoLugarSeeder;
use Database\Seeders\CarroceriaCocheSeeder;
use Database\Seeders\MarcaCocheSeeder;
use Database\Seeders\IdiomaSeeder;
use Database\Seeders\PaisSeeder;
use Database\Seeders\LugarSeeder;
use Database\Seeders\CocheSeeder;
use Database\Seeders\AlquilerSeeder;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ContinenteSeeder::class,
            IdiomaSeeder::class,
            PaisSeeder::class,
            TipoLugarSeeder::class,
            LugarSeeder::class,
            CarroceriaCocheSeeder::class,
            MarcaCocheSeeder::class,
            CocheSeeder::class,
            AlquilerSeeder::class,
        ]);
    }
}
