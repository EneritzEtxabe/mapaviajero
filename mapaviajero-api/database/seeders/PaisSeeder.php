<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Pais;
use App\Models\Continente;
use App\Models\Idioma;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $continentes = [
            'Asia','África','Europa','Oceanía','Sudamérica','Norteamérica','Antártida'
        ];
        $continentesMap = [];
        foreach ($continentes as $nombre) {
            $continentesMap[$nombre] = Continente::where('nombre', $nombre)->first()?->id;
        }
        
        $idiomas = [
            'Inglés','Euskera','Árabe','Castellano','Francés','Alemán','Chino','Catalán'
        ];
        $idiomasMap = [];
        foreach ($idiomas as $idioma) {
            $idiomasMap[$idioma] = Idioma::where('nombre', $idioma)->first()?->id;
        }

        $paises = [
            [
                'nombre' => 'Albania',
                'capital' => 'Tirana',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Flag_of_Albania.svg/60px-Flag_of_Albania.svg.png',
                'conduccion' => 'izquierda',
                'continente_id' => $continentesMap['Europa'],
                'idiomas' => [$idiomasMap['Inglés']],
            ],
            [
                'nombre' => 'Alemania',
                'capital' => 'Berlín',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Flag_of_Germany.svg/60px-Flag_of_Germany.svg.png',
                'conduccion' => 'izquierda',
                'continente_id' => $continentesMap['Europa'],
                'idiomas' => [$idiomasMap['Alemán']],
            ],
            [
                'nombre' => 'Andorra',
                'capital' => 'Andorra la Vieja',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Flag_of_Andorra.svg/60px-Flag_of_Andorra.svg.png',
                'conduccion' => 'izquierda',
                'continente_id' => $continentesMap['Europa'],
                'idiomas' => [$idiomasMap['Catalán'],$idiomasMap['Castellano'], $idiomasMap['Francés']],
            ],
            [
                'nombre' => 'Australia',
                'capital' => 'Camberra',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Flag_of_Australia.svg/60px-Flag_of_Australia.svg.png',
                'conduccion' => 'derecha',
                'continente_id' => $continentesMap['Oceanía'],
                'idiomas' => [$idiomasMap['Inglés']],
            ],
            [
                'nombre' => 'Cabo Verde',
                'capital' => 'Praia',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/38/Flag_of_Cape_Verde.svg/60px-Flag_of_Cape_Verde.svg.png',
                'conduccion' => 'derecha',
                'continente_id' => $continentesMap['África'],
                'idiomas' => [$idiomasMap['Inglés']],
            ],
            [
                'nombre' => 'España',
                'capital' => 'Madrid',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Flag_of_Spain.svg/60px-Flag_of_Spain.svg.png',
                'conduccion' => 'izquierda',
                'continente_id' => $continentesMap['Europa'],
                'idiomas' => [$idiomasMap['Castellano'], $idiomasMap['Euskera'], $idiomasMap['Catalán']],
            ],
            [
                'nombre' => 'Estados Unidos',
                'capital' => 'Washington D.C',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/60px-Flag_of_the_United_States.svg.png',
                'conduccion' => 'izquierda',
                'continente_id' => $continentesMap['Norteamérica'],
                'idiomas' => [$idiomasMap['Inglés']],
            ],
            [
                'nombre' => 'Filipinas',
                'capital' => 'Manila',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Flag_of_the_Philippines.svg/60px-Flag_of_the_Philippines.svg.png',
                'conduccion' => 'izquierda',
                'continente_id' => $continentesMap['Asia'],
                'idiomas' => [$idiomasMap['Inglés']],
            ],
            [
                'nombre' => 'Islandia',
                'capital' => 'Reikiavik',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ce/Flag_of_Iceland.svg/60px-Flag_of_Iceland.svg.png',
                'conduccion' => 'izquierda',
                'continente_id' => $continentesMap['Europa'],
                'idiomas' => [$idiomasMap['Inglés']],
            ],
            [
                'nombre' => 'Malasia',
                'capital' => 'Kuala Lumpur',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/Flag_of_Malaysia.svg/60px-Flag_of_Malaysia.svg.png',
                'conduccion' => 'derecha',
                'continente_id' => $continentesMap['Asia'],
                'idiomas' => [$idiomasMap['Inglés']],
            ],
            [
                'nombre' => 'Argentina',
                'capital' => 'Buenos Aires',
                'bandera_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Flag_of_Argentina.svg/800px-Flag_of_Argentina.svg.png?20120912082242',
                'conduccion' => 'izquierda',
                'continente_id' => $continentesMap['Sudamérica'],
                'idiomas' => [$idiomasMap['Castellano']],
            ],
            
        ];

        foreach ($paises as $data) {
            $pais = Pais::firstOrCreate([
                'nombre' => $data['nombre'],
                'continente_id' => $data['continente_id'],
                'capital' => $data['capital'],
                'bandera_url' => $data['bandera_url'],
                'conduccion' => $data['conduccion'],
            ]);
            $pais->idiomas()->syncWithoutDetaching($data['idiomas']);
        }
    }
}
