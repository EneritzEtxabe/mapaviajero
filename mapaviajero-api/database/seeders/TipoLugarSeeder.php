<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TipoLugar;

class TipoLugarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos=['Naturaleza','Deporte','Aventura','Parques temáticos','Salud y Bienestar','Gastronomía','Cultura','Montaña','Playa','Rural','Ciudad'];

        foreach($tipos as $tipo){
            TipoLugar::firstOrCreate(['nombre'=>$tipo]);
        }
    }
}
