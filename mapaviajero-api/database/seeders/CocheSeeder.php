<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Pais;
use App\Models\Coche;
use App\Models\MarcaCoche;
use App\Models\CarroceriaCoche;

class CocheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paises = [
            'Albania','Alemania','Andorra','Australia','Cabo Verde','España','Estados Unidos','Filipinas','Islandia','Malasia','Argentina'
        ];
        $paisesMap = [];
        foreach ($paises as $pais) {
            $paisesMap[$pais] = Pais::where('nombre', $pais)->first()?->id;
        }
        $marcas = [
            'Toyota','Volkswagen','BMW','Ford','Audi','Kia','Peugeot','Hyundai','Renault','Nissan'
        ];
        $marcasMap = [];
        foreach ($marcas as $marca) {
            $marcasMap[$marca] = MarcaCoche::where('nombre', $marca)->first()?->id;
        }
        $carrocerias = [
            'Sedán','Familiar','Cupé','SUV','Monovolumen','Pick-up','Descapotable'
        ];
        $carroceriasMap = [];
        foreach ($carrocerias as $carroceria) {
            $carroceriasMap[$carroceria] = CarroceriaCoche::where('nombre', $carroceria)->first()?->id;
        }

        $coches = [
            [   
                'marca' => $marcasMap['Toyota'],
                'carroceria' => $carroceriasMap['SUV'],         
                'ano' => 2020, 
                'nPlazas' => 5, 
                'cambio' => 'automático', 
                'estado' => 'disponible',   
                'costeDia' => 55.00, 
                'pais' => $paisesMap['España']
            ],
            [
                'marca' => $marcasMap['Volkswagen'],  
                'carroceria' => $carroceriasMap['Sedán'],       
                'ano' => 2019, 
                'nPlazas' => 5, 
                'cambio' => 'manual',     
                'estado' => 'mantenimiento',
                'costeDia' => 48.50, 
                'pais' => $paisesMap['Alemania']
            ],
            [
                'marca' => $marcasMap['BMW'],         
                'carroceria' => $carroceriasMap['Cupé'],        
                'ano' => 2022, 
                'nPlazas' => 4, 
                'cambio' => 'automático', 
                'estado' => 'disponible',   
                'costeDia' => 80.00, 
                'pais' => $paisesMap['Argentina']
            ],
            [
                'marca' => $marcasMap['Ford'],        
                'carroceria' => $carroceriasMap['Pick-up'],     
                'ano' => 2018, 
                'nPlazas' => 2, 
                'cambio' => 'manual',     
                'estado' => 'disponible',   
                'costeDia' => 60.00, 
                'pais' => $paisesMap['Estados Unidos']
            ],
            [
                'marca' => $marcasMap['Audi'],        
                'carroceria' => $carroceriasMap['Descapotable'],
                'ano' => 2023, 
                'nPlazas' => 4, 
                'cambio' => 'automático', 
                'estado' => 'disponible',   
                'costeDia' => 90.00, 
                'pais' => $paisesMap['Islandia']
            ],
            [
                'marca' => $marcasMap['Kia'],         
                'carroceria' => $carroceriasMap['Monovolumen'], 
                'ano' => 2021, 
                'nPlazas' => 7, 
                'cambio' => 'manual',     
                'estado' => 'mantenimiento',
                'costeDia' => 70.00, 
                'pais' => $paisesMap['Malasia']
            ],
            [
                'marca' => $marcasMap['Peugeot'],     
                'carroceria' => $carroceriasMap['Familiar'],    
                'ano' => 2017, 
                'nPlazas' => 5, 
                'cambio' => 'manual',     
                'estado' => 'disponible',   
                'costeDia' => 45.00, 
                'pais' => $paisesMap['Albania']
            ],
            [
                'marca' => $marcasMap['Hyundai'],     
                'carroceria' => $carroceriasMap['Sedán'],       
                'ano' => 2016, 
                'nPlazas' => 5, 
                'cambio' => 'automático', 
                'estado' => 'disponible',   
                'costeDia' => 40.00, 
                'pais' => $paisesMap['Filipinas']
            ],
            [
                'marca' => $marcasMap['Renault'],     
                'carroceria' => $carroceriasMap['Familiar'],    
                'ano' => 2015, 
                'nPlazas' => 5, 
                'cambio' => 'manual',     
                'estado' => 'mantenimiento',
                'costeDia' => 35.00, 
                'pais' => $paisesMap['Andorra']
            ],
            [
                'marca' => $marcasMap['Nissan'],      
                'carroceria' => $carroceriasMap['SUV'],         
                'ano' => 2024, 
                'nPlazas' => 5, 
                'cambio' => 'automático', 
                'estado' => 'disponible',   
                'costeDia' => 75.00, 
                'pais' => $paisesMap['Australia']
            ],
            
        ];

        foreach ($coches as $data) {
            $coche = Coche::firstOrCreate([
                'marca_id' => $data['marca'],      
                'carroceria_id' => $data['carroceria'],         
                'ano' => $data['ano'], 
                'nPlazas' => $data['nPlazas'], 
                'cambio' => $data['cambio'], 
                'estado' => $data['estado'],   
                'costeDia' => $data['costeDia'], 
                'pais_id' => $data['pais']
            ]);
        }
    }
}
