<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Club\Repositories\Interfaces\PositionStaffRepositoryInterface;

class PositionStaffTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $positionStaffRepository;

    public function __construct(PositionStaffRepositoryInterface $positionStaffRepository)
    {
        $this->positionStaffRepository = $positionStaffRepository;
    }

    /**
     * @return void
     */
    protected function createPositionStaff(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->positionStaffRepository->create($elm);
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
                    'name' => 'Entrenador'
                ],
                'en' => [
                    'name' => 'Coach'
                ],
                'code' => 'coach'
            ],
            [
                'es' => [
                    'name' => 'Segundo entrenador'
                ],
                'en' => [
                    'name' => 'Second coach'
                ],
                'code' => 'second_coah'
            ],
            [
                'es' => [
                    'name' => 'Entrenador de porteros'
                ],
                'en' => [
                    'name' => 'Goalkeeping coach'
                ],
                'code' => 'goalkeeping_coach'
            ],
            [
                'es' => [
                    'name' => 'Preparador físico'
                ],
                'en' => [
                    'name' => 'Physical trainer'
                ],
                'code' => 'physical_trainer'
            ],
            [
                'es' => [
                    'name' => 'Reeducador funcional deportivo'
                ],
                'en' => [
                    'name' => 'Sports functional re-educator'
                ],
                'code' => 'functional_reeducator'
            ],
            [
                'es' => [
                    'name' => 'Médico'
                ],
                'en' => [
                    'name' => 'Doctor'
                ],
                'code' => 'doctor'
            ],
            [
                'es' => [
                    'name' => 'Fisioterapéuta'
                ],
                'en' => [
                    'name' => 'Physiotherapist'
                ],
                'code' => 'physiotherapist'
            ],
            [
                'es' => [
                    'name' => 'Osteópata'
                ],
                'en' => [
                    'name' => 'Osteopath'
                ],
                'code' => 'osteopath'
            ],
            [
                'es' => [
                    'name' => 'Masajista'
                ],
                'en' => [
                    'name' => 'Massage therapist'
                ],
                'code' => 'massage_therapist'
            ],
            [
                'es' => [
                    'name' => 'Analista'
                ],
                'en' => [
                    'name' => 'Analyst'
                ],
                'code' => 'analyst'
            ],
            [
                'es' => [
                    'name' => 'Ojeador'
                ],
                'en' => [
                    'name' => 'Scout'
                ],
                'code' => 'scout'
            ],
            [
                'es' => [
                    'name' => 'Nutricionista'
                ],
                'en' => [
                    'name' => 'Nutritionist'
                ],
                'code' => 'nutritionist'
            ],
            [
                'es' => [
                    'name' => 'Psicólogo'
                ],
                'en' => [
                    'name' => 'Psychologist'
                ],
                'code' => 'psychologist'
            ],
            [
                'es' => [
                    'name' => 'Utillero'
                ],
                'en' => [
                    'name' => 'Utillero'
                ],
                'code' => 'utillero'
            ],
            [
                'es' => [
                    'name' => 'Ayudante / asistente'
                ],
                'en' => [
                    'name' => 'Helper / assistant'
                ],
                'code' => 'helper'
            ],
            [
                'es' => [
                    'name' => 'Otro'
                ],
                'en' => [
                    'name' => 'Other'
                ],
                'code' => 'other'
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPositionStaff($this->get()->current());
    }
}
