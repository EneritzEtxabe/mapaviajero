<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Alquiler;
use App\Models\Coche;
use App\Models\User;

class AlquilerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $coches = Coche::all();
        $clientes = User::where('rol', 'cliente')->pluck('id')->toArray();

        $alquileres = [
            [
                'fecha_inicio' => '2025-01-01',
                'fecha_fin' => '2025-01-05',
                'coste' => 100.00,
                'coche_id' => $coches[0]->id,
                'cliente_id' => $clientes[0],
            ],
            [
                'fecha_inicio' => '2025-01-06',
                'fecha_fin' => '2025-01-10',
                'coste' => 120.00,
                'coche_id' => $coches[0]->id,
                'cliente_id' => $clientes[1],
            ],
            [
                'fecha_inicio' => '2025-01-03',
                'fecha_fin' => '2025-01-07',
                'coste' => 130.00,
                'coche_id' => $coches[1]->id,
                'cliente_id' => $clientes[2],
            ],
            [
                'fecha_inicio' => '2025-01-08',
                'fecha_fin' => '2025-01-12',
                'coste' => 140.00,
                'coche_id' => $coches[1]->id,
                'cliente_id' => $clientes[2],
            ],
            [
                'fecha_inicio' => '2025-01-02',
                'fecha_fin' => '2025-01-04',
                'coste' => 90.00,
                'coche_id' => $coches[2]->id,
                'cliente_id' => $clientes[0],
            ],
            [
                'fecha_inicio' => '2025-01-05',
                'fecha_fin' => '2025-01-09',
                'coste' => 150.00,
                'coche_id' => $coches[3]->id,
                'cliente_id' => $clientes[1],
            ],
            [
                'fecha_inicio' => '2025-01-10',
                'fecha_fin' => '2025-01-14',
                'coste' => 160.00,
                'coche_id' => $coches[3]->id,
                'cliente_id' => $clientes[0],
            ],
            [
                'fecha_inicio' => '2025-01-06',
                'fecha_fin' => '2025-01-11',
                'coste' => 200.00,
                'coche_id' => $coches[4]->id,
                'cliente_id' => $clientes[2],
            ],
            [
                'fecha_inicio' => '2025-01-12',
                'fecha_fin' => '2025-01-16',
                'coste' => 220.00,
                'coche_id' => $coches[4]->id,
                'cliente_id' => $clientes[1],
            ],
            [
                'fecha_inicio' => '2025-01-15',
                'fecha_fin' => '2025-01-18',
                'coste' => 180.00,
                'coche_id' => $coches[5]->id,
                'cliente_id' => $clientes[0],
            ],
        ];

        foreach ($alquileres as $data) {
            $alquiler = Alquiler::firstOrCreate([
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_fin' => $data['fecha_fin'],
                'coste' => $data['coste'],
                'coche_id' => $data['coche_id'],
                'cliente_id' => $data['cliente_id'],
            ]);
        }
    }
}
