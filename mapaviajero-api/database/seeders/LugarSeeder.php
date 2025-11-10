<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Lugar;
use App\Models\Pais;
use App\Models\TipoLugar;

class LugarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paises = [
            'Albania', 'Alemania', 'Andorra', 'Australia', 'Cabo Verde', 'España', 'Estados Unidos', 'Filipinas', 'Islandia', 'Malasia', 'Argentina'
        ];
        $paisesMap = [];
        foreach ($paises as $nombre) {
            $paisesMap[$nombre] = Pais::where('nombre', $nombre)->first()?->id;
        }

        $tipos=['Cultura','Naturaleza','Gastronomía','Deporte','Salud y Bienestar','Rural','Aventura','Playa','Montaña', 'Ciudad','Parques temáticos'];

        $tiposLugar = [];
        foreach ($tipos as $tipo) {
            $tiposLugar[$tipo] = TipoLugar::where('nombre', $tipo)->first()?->id;
        }

        $lugares = [
           [
                'nombre' => 'Castillo de Berat',
                'descripcion' => 'Castillo histórico sobre una colina con vistas espectaculares, símbolo cultural de Albania.',
                'pais_id' => $paisesMap['Albania'],
                'imagen_url' => 'https://www.travelreport.mx/wp-content/uploads/2024/07/castillo-de-berat.jpg',
                'web_url' => 'https://en.wikipedia.org/wiki/Berat_Castle',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.98131406727!2d19.943123476438778!3d40.71031103771837!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x135aa206cb09425f%3A0x5bfec4096f776e8d!2sCastillo%20de%20Berat!5e1!3m2!1ses!2ses!4v1760820823355!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Cultura'], $tiposLugar['Montaña']],
            ],
            [
                'nombre' => 'Puerta de Brandeburgo',
                'descripcion' => 'Icono de Berlín y símbolo de la reunificación alemana.',
                'pais_id' => $paisesMap['Alemania'],
                'imagen_url' => 'https://www.losviajesdegrimes.com/wp-content/uploads/2019/12/puerta-de-brandenburgo.jpg',
                'web_url' => 'https://www.berlin.de/en/attractions-and-sights/3560264-3104052-brandenburg-gate.en.html',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2905.3181357080502!2d13.375129176947537!3d52.516277836504784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47a851c655f20989%3A0x26bbfb4e84674c63!2sPuerta%20de%20Brandeburgo!5e1!3m2!1ses!2ses!4v1760820792616!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Cultura'], $tiposLugar['Ciudad']]
            ],
            [
                'nombre' => 'Centro histórico de Andorra la Vella',
                'descripcion' => 'Casco antiguo con arquitectura románica y calles empedradas.',
                'pais_id' => $paisesMap['Andorra'],
                'imagen_url' => 'https://blog.kioneresorts.com/wp-content/uploads/2022/11/andorra-la-vella-vista-aerea.jpg',
                'web_url' => 'https://en.wikipedia.org/wiki/Andorra_la_Vella',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3519.489645074563!2d1.5182194145299999!3d42.5084362513127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a5f54fb67fd375%3A0x1c2039fc143bddc7!2sCentro%20Cultural%20La%20Llacuna!5e1!3m2!1ses!2ses!4v1760820756110!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Cultura'], $tiposLugar['Montaña'], $tiposLugar['Ciudad']],
            ],
            [
                'nombre' => 'Ópera de Sídney',
                'descripcion' => 'Monumento arquitectónico y centro cultural en la bahía de Sídney.',
                'pais_id' => $paisesMap['Australia'],
                'imagen_url' => 'https://content-historia.nationalgeographic.com.es/medio/2023/10/19/un-edificio-muy-caro_114ddd43_509843968_231019181438_2000x1333.jpg',
                'web_url' => 'https://www.sydneyoperahouse.com',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.7142566079183!2d151.2127217764673!3d-33.856779918437695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae665e892fdd%3A0x3133f8d75a1ac251!2zw5NwZXJhIGRlIFPDrWRuZXk!5e1!3m2!1ses!2ses!4v1760820677771!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Cultura'], $tiposLugar['Ciudad']],
            ],
            [
                'nombre' => 'Playa de Santa María',
                'descripcion' => 'Una de las playas más hermosas de Cabo Verde, ideal para el descanso y deportes acuáticos.',
                'pais_id' => $paisesMap['Cabo Verde'],
                'imagen_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ0W5h9j8TVvFr2dBdYvI9UU_52CBZntohrNA&s',
                'web_url' => 'https://en.wikipedia.org/wiki/Santa_Maria%2C_Cape_Verde',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2287.70673871656!2d-22.91519870160524!3d16.595035200000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94b5d823a815cf3%3A0x3a49c478cf69fb5e!2sSanta%20Maria%20Beach!5e1!3m2!1ses!2ses!4v1760820634339!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Playa'], $tiposLugar['Aventura']],
            ],
            [
                'nombre' => 'La Alhambra',
                'descripcion' => 'Palacio y fortaleza morisca en Granada, joya del arte islámico.',
                'pais_id' => $paisesMap['España'],
                'imagen_url' => 'https://tripgranada.com/wp-content/uploads/2023/10/que-es-la-alhambra-de-granada.jpg',
                'web_url' => 'https://www.alhambra-patronato.es',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15581419.651664943!2d-15.096109778082893!3d37.17607830000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd71fcb7977fb93b%3A0x808dd1ef1221a27f!2sAlhambra!5e1!3m2!1ses!2ses!4v1760820590222!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Cultura'], $tiposLugar['Ciudad']],
            ],
            [
                'nombre' => 'Gran Cañón',
                'descripcion' => 'Impresionante cañón en Arizona con vistas naturales únicas.',
                'pais_id' => $paisesMap['Estados Unidos'],
                'imagen_url' => 'https://d2l4159s3q6ni.cloudfront.net/resize/1200x600/filters:max_age(2604800):quality(65)/s3/dam/photos/76/04/fc/d2/a9d98ae8e3c1abda48b320c6c7a9b004d98060e7902da99ef733d91a.jpg',
                'web_url' => 'https://www.nps.gov/grca/index.htm',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13004139.131300298!2d-109.43125993076613!3d34.495703919261395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80cc0654bd27e08d%3A0xb1c2554442d42e8d!2zR3JhbiBDYcOxw7Nu!5e1!3m2!1ses!2ses!4v1760820543938!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Naturaleza'], $tiposLugar['Aventura']],
            ],
            [
                'nombre' => 'Intramuros',
                'descripcion' => 'Barrio colonial amurallado en Manila.',
                'pais_id' => $paisesMap['Filipinas'],
                'imagen_url' => 'https://gttp.images.tshiftcdn.com/253912/x/0/baluarte.jpg?width=360&height=250&fit=crop&quality=75&dpr=2',
                'web_url' => 'https://intramuros.gov.ph',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9240.67227231608!2d120.9692466443992!3d14.589205726514232!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ca3d1375e1fb%3A0x49ebfa658c0ba08!2sIntramuros%2C%20Manila%2C%201002%20Gran%20Manila%2C%20Filipinas!5e1!3m2!1ses!2ses!4v1760820493982!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Cultura'], $tiposLugar['Ciudad']],
            ],
            [
                'nombre' => 'Blue Lagoon',
                'descripcion' => 'Laguna termal geotérmica famosa por su experiencia de relajación.',
                'pais_id' => $paisesMap['Islandia'],
                'imagen_url' => 'https://content.icelandtravel.is/wp-content/uploads/2019/03/1200px-Blue_Lagoon_Iceland_22360145156.jpg',
                'web_url' => 'https://www.bluelagoon.com',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2101.8330901868535!2d-22.449871322466702!3d63.880719938769225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48d61d66aff7df0d%3A0xf3747a894416f06e!2sBlue%20Lagoon!5e1!3m2!1ses!2ses!4v1760820441470!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Salud y Bienestar'], $tiposLugar['Naturaleza']],
            ],
            [
                'nombre' => 'Torres Petronas',
                'descripcion' => 'Rascacielos gemelos icónicos de Kuala Lumpur.',
                'pais_id' => $paisesMap['Malasia'],
                'imagen_url' => 'https://estaticos-cdn.prensaiberica.es/clip/e9eec1b9-31f5-464d-911e-761b36191c03_source-aspect-ratio_default_0.jpg',
                'web_url' => 'https://www.petronastwintowers.com.my',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12201414.554782722!2d95.54034917101099!3d1.4731792916566204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc37d12d669c1f%3A0x9e3afdd17c8a9056!2sTorres%20Petronas!5e1!3m2!1ses!2ses!4v1760820404344!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Ciudad']],
            ],
            [
                'nombre' => 'Cataratas del Iguazú',
                'descripcion' => 'Maravilla natural del mundo compartida entre Argentina y Brasil.',
                'pais_id' => $paisesMap['Argentina'],
                'imagen_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2e/ed/a5/17/foz-do-iguacu.jpg?w=900&h=500&s=1',
                'web_url' => 'https://iguazuargentina.com',
                'localizacion_url' => 'https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d8604.61961672299!2d-54.44620380397044!3d-25.69112904133334!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sCATARATAS%20DEL%20IGUAZU!5e1!3m2!1ses!2ses!4v1760812310589!5m2!1ses!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
                'tiposLugar' => [$tiposLugar['Naturaleza'], $tiposLugar['Aventura']],
            ]
        ];

        foreach ($lugares as $data) {
            $lugar = Lugar::firstOrCreate([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'],
                'pais_id'=>$data['pais_id'],
                'imagen_url' => $data['imagen_url'],
                'web_url' => $data['web_url'],
                'localizacion_url' => $data['localizacion_url'],
            ]);
            $lugar->tipoLugares()->syncWithoutDetaching($data['tiposLugar']);
        }
    }
}
