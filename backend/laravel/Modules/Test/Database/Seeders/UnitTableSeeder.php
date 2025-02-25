<?php

namespace Modules\Test\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Test\Repositories\Interfaces\UnitRepositoryInterface;

class UnitTableSeeder extends Seeder
{
    
    /**
     * @var object
     */
    protected $unitRepository;

    public function __construct(UnitRepositoryInterface $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    /**
     * @return void
     */
    protected function createUnit(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->unitRepository->create($elm);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Kilogramo'
                        ],
                'en' => [
                    'name' => 'Kilogram'
                ],
                'code'           => 'kg',
                'abbreviation'   => 'kg'
            ],
            [
                'es' => [
                    'name' => 'Libra'
                ],
                'en' => [
                    'name' => 'Pound'
                ],
                'code'           => 'lb',
                'abbreviation'   => 'lb'
            ],
            [
                'es' => [
                    'name' => 'Metros'
                ],
                'en' => [
                    'name' => 'Meters'
                ],
                'code'           => 'm',
                'abbreviation'   => 'm'
            ],
            [
                'es' => [
                    'name' => 'Centimetros'
                ],
                'en' => [
                    'name' => 'Centimeters'
                ],
                'code'           => 'cm',
                'abbreviation'   => 'cm'
            ],
            [
                'es' => [
                    'name' => 'Milimetros'
                ],
                'en' => [
                    'name' => 'Millimeters'
                ],
                'code'           => 'mm',
                'abbreviation'   => 'mm'
            ],
            [
                'es' => [
                    'name' => 'Minutos'
                ],
                'en' => [
                    'name' => 'Minutes'
                ],
                'code'           => 'min',
                'abbreviation'   => 'min'
            ],
            [
                'es' => [
                    'name' => 'Milisegundos'
                ],
                'en' => [
                    'name' => 'Milliseconds'
                ],
                'code'           => 'ms',
                'abbreviation'   => 'ms'
            ],
            [
                'es' => [
                    'name' => 'Segundos'
                ],
                'en' => [
                    'name' => 'Seconds'
                ],
                'code'           => 'sg',
                'abbreviation'   => 'sg'
            ],
            [
                'es' => [
                    'name' => 'Milesimas'
                ],
                'en' => [
                    'name' => 'Thousandths'
                ],
                'code'           => 'mil',
                'abbreviation'   => 'mm'
            ],
            [
                'es' => [
                    'name' => 'Push up'
                ],
                'en' => [
                    'name' => 'Push up'
                ],
                'code'           => 'push-up',
                'abbreviation'   => ''
            ],
            [
                'es' => [
                    'name' => 'Número de contactos'
                ],
                'en' => [
                    'name' => 'Number of contacts'
                ],
                'code'           => 'contacts',
                'abbreviation'   => 'Contacto'
            ],
            [
                'es' => [
                    'name' => 'Número'
                ],
                'en' => [
                    'name' => 'Number'
                ],
                'code'           => 'n',
                'abbreviation'   => 'n°'
            ],
            [
                'es' => [
                    'name' => 'Intentos'
                ],
                'en' => [
                    'name' => 'Attempt'
                ],
                'code'           => 'intentos',
                'abbreviation'   => 'Intentos'
            ],
            [
                'es' => [
                    'name' => 'Saltos'
                ],
                'en' => [
                    'name' => 'Jumps'
                ],
                'code'           => 'jumps',
                'abbreviation'   => 'Jumps'
            ],
            [
                'es' => [
                    'name' => 'Newton'
                ],
                'en' => [
                    'name' => 'Newton'
                ],
                'code'           => 'newton',
                'abbreviation'   => 'N'
            ],
            [
                'es' => [
                    'name' => 'Watios'
                ],
                'en' => [
                    'name' => 'Watios'
                ],
                'code'           => 'watios',
                'abbreviation'   => 'W'
            ],
            [
                'es' => [
                    'name' => 'Pulsaciones por minuto(ppm)'
                ],
                'en' => [
                    'name' => 'Beats per minute(bpm)'
                ],
                'code'           => 'ppm',
                'abbreviation'   => 'ppm/bpm'
            ],
            [
                'es' => [
                    'name' => 'Mililitos/Kilogramos/Minutos'
                ],
                'en' => [
                    'name' => 'Mililiters/Kilograms/Minutes'
                ],
                'code'           => 'vo2max',
                'abbreviation'   => 'ml/kg/min'
            ],
            [
                'es' => [
                    'name' => 'Metros/Segundos'
                ],
                'en' => [
                    'name' => 'Meters/Seconds'
                ],
                'code'           => 'm/s',
                'abbreviation'   => 'm/s'
            ],
            [
                'es' => [
                    'name' => 'Metros/Minutos'
                ],
                'en' => [
                    'name' => 'Meters/minutes'
                ],
                'code'           => 'm/min',
                'abbreviation'   => 'm/min'
            ],
            [
                'es' => [
                    'name' => 'Metros/Segundos al cuadrado'
                ],
                'en' => [
                    'name' => 'Meters/Seconds squared'
                ],
                'code'           => 'm/s2',
                'abbreviation'   => 'm/s2'
            ],
            [
                'es' => [
                    'name' => 'Kilometros/hora'
                ],
                'en' => [
                    'name' => 'Kilometers/hour'
                ],
                'code'           => 'km/h',
                'abbreviation'   => 'km/h'
            ],      
            [
                'es' => [
                    'name' => 'Trabajo/kilogramos'
                ],
                'en' => [
                    'name' => 'Work/Kilograms'
                ],
                'code'           => 'w/kg',
                'abbreviation'   => 'w/kg'
            ],
            [
                'es' => [
                    'name' => 'Porcentaje'
                ],
                'en' => [
                    'name' => 'Percentage'
                ],
                'code'           => 'percentage',
                'abbreviation'   => '%'
            ],
            [
                'es' => [
                    'name' => 'Periodo / Nivel'
                ],
                'en' => [
                    'name' => 'Period / Level'
                ],
                'code'           => 'period',
                'abbreviation'   => 'periodo'
            ],
            [
                'es' => [
                    'name' => 'Nº dominadas'
                ],
                'en' => [
                    'name' => 'Nº push ups'
                ],
                'code'           => 'dominada',
                'abbreviation'   => 'Dominadas'
            ],
            [
                'es' => [
                    'name' => 'Nº flexiones'
                ],
                'en' => [
                    'name' => 'Nº push ups'
                ],
                'code'           => 'flexiones',
                'abbreviation'   => 'Flexiones'
            ],
            [
                'es' => [
                    'name' => 'número capturas'
                ],
                'en' => [
                    'name' => 'Number of captures'
                ],
                'code'           => 'captures',
                'abbreviation'   => 'Capturas'
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUnit($this->get()->current());
    }
}
