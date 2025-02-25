<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use Modules\Generality\Repositories\Interfaces\JobAreaRepositoryInterface;
use Modules\Club\Repositories\Interfaces\PositionStaffRepositoryInterface;

class JobsAreaTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $jobAreaRepository;

    /**
     * @var object
     */
    protected $positionStaffRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        JobAreaRepositoryInterface $jobAreaRepository,
        PositionStaffRepositoryInterface $positionStaffRepository
    ) {
        $this->jobAreaRepository = $jobAreaRepository;
        $this->positionStaffRepository = $positionStaffRepository;
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Directiva'
                ],
                'en' => [
                    'name' => 'Directive'
                ],
                'code' => 'directive',
                'positions' => [
                    [
                        'es' => [
                            'name' => 'Presidente'
                        ],
                        'en' => [
                            'name' => 'President'
                        ],
                        'code' => 'president',
                    ],
                    [
                        'es' => [
                            'name' => 'Vice-Presidente'
                        ],
                        'en' => [
                            'name' => 'Vice-President'
                        ],
                        'code' => 'vice_president',
                    ],
                    [
                        'es' => [
                            'name' => 'Director General / CEO'
                        ],
                        'en' => [
                            'name' => 'Managing Director / CEO'
                        ],
                        'code' => 'ceo',
                    ],
                    [
                        'es' => [
                            'name' => 'Director Deportivo'
                        ],
                        'en' => [
                            'name' => 'Sports Director'
                        ],
                        'code' => 'sport_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Otro'
                        ],
                        'en' => [
                            'name' => 'Other'
                        ],
                        'code' => 'directive_other',
                    ],
                ],
            ],
            [
                'es' => [
                    'name' => 'Económica y Administrativa'
                ],
                'en' => [
                    'name' => 'Economic and Administrative'
                ],
                'code' => 'economic_administrative',
                'positions' => [
                    [
                        'es' => [
                            'name' => 'Director de ventas'
                        ],
                        'en' => [
                            'name' => 'Sales director'
                        ],
                        'code' => 'sales_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Tesorero'
                        ],
                        'en' => [
                            'name' => 'Treasurer'
                        ],
                        'code' => 'treasurer',
                    ],
                    [
                        'es' => [
                            'name' => 'Secretario'
                        ],
                        'en' => [
                            'name' => 'Secretary'
                        ],
                        'code' => 'secretary',
                    ],
                    [
                        'es' => [
                            'name' => 'Otro'
                        ],
                        'en' => [
                            'name' => 'Other'
                        ],
                        'code' => 'economic_other',
                    ],
                ],
            ],
            [
                'es' => [
                    'name' => 'Recursos humanos'
                ],
                'en' => [
                    'name' => 'Human resources'
                ],
                'code' => 'human_resources',
                'positions' => [
                    [
                        'es' => [
                            'name' => 'Director de Personal'
                        ],
                        'en' => [
                            'name' => 'Personnel Director'
                        ],
                        'code' => 'personnel_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Responsable de formación'
                        ],
                        'en' => [
                            'name' => 'Responsible character'
                        ],
                        'code' => 'responsible_character',
                    ],
                    [
                        'es' => [
                            'name' => 'Otro'
                        ],
                        'en' => [
                            'name' => 'Other'
                        ],
                        'code' => 'hr_other',
                    ],
                ],
            ],
            [
                'es' => [
                    'name' => 'Social y Comunicación'
                ],
                'en' => [
                    'name' => 'Social and communication'
                ],
                'code' => 'social_communication',
                'positions' => [
                    [
                        'es' => [
                            'name' => 'Director de marketing'
                        ],
                        'en' => [
                            'name' => 'Marketing director'
                        ],
                        'code' => 'marketing_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Director de comunicación'
                        ],
                        'en' => [
                            'name' => 'Director of communication'
                        ],
                        'code' => 'director_communication',
                    ],
                    [
                        'es' => [
                            'name' => 'Director del área social'
                        ],
                        'en' => [
                            'name' => 'Director of the social area'
                        ],
                        'code' => 'social_area_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Responsable de redes sociales'
                        ],
                        'en' => [
                            'name' => 'Responsible for social networks'
                        ],
                        'code' => 'social_network_responsible',
                    ],
                    [
                        'es' => [
                            'name' => 'Responsable de relaciones institucionales'
                        ],
                        'en' => [
                            'name' => 'Head of institutional relations'
                        ],
                        'code' => 'institutional_responsible',
                    ],
                    [
                        'es' => [
                            'name' => 'Responsable de eventos y actividades'
                        ],
                        'en' => [
                            'name' => 'Responsible for events and activities'
                        ],
                        'code' => 'events_responsible',
                    ],
                    [
                        'es' => [
                            'name' => 'Otro'
                        ],
                        'en' => [
                            'name' => 'Other'
                        ],
                        'code' => 'social_other',
                    ],
                ],
            ],
            [
                'es' => [
                    'name' => 'Deportiva'
                ],
                'en' => [
                    'name' => 'Sports'
                ],
                'code' => 'sports',
                'positions' => [
                    [
                        'es' => [
                            'name' => 'Director técnico'
                        ],
                        'en' => [
                            'name' => 'Technical director'
                        ],
                        'code' => 'technical_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Coordinador de categorías inferiores'
                        ],
                        'en' => [
                            'name' => 'Youth coordinator'
                        ],
                        'code' => 'youth_coordinator',
                    ],
                    [
                        'es' => [
                            'name' => 'Delegado del equipo'
                        ],
                        'en' => [
                            'name' => 'Team delegate'
                        ],
                        'code' => 'team_delegate',
                    ],
                    [
                        'es' => [
                            'name' => 'Responsable de rendimiento'
                        ],
                        'en' => [
                            'name' => 'Responsible for performance'
                        ],
                        'code' => 'performance_responsible',
                    ],
                    [
                        'es' => [
                            'name' => 'Entrenador'
                        ],
                        'en' => [
                            'name' => 'Trainer'
                        ],
                        'code' => 'trainer',
                    ],
                    [
                        'es' => [
                            'name' => 'Segundo entrenador'
                        ],
                        'en' => [
                            'name' => 'Second trainer'
                        ],
                        'code' => 'second_trainer',
                    ],
                    [
                        'es' => [
                            'name' => 'Entrenador de porteros'
                        ],
                        'en' => [
                            'name' => 'Goalkeeper trainer'
                        ],
                        'code' => 'goalkeeper_trainer',
                    ],
                    [
                        'es' => [
                            'name' => 'Preparador físico'
                        ],
                        'en' => [
                            'name' => 'Physical trainer'
                        ],
                        'code' => 'physical_trainer',
                    ],
                    [
                        'es' => [
                            'name' => 'Reeducador funcional deportivo'
                        ],
                        'en' => [
                            'name' => 'Sports functional re-educator'
                        ],
                        'code' => 'functional_reeducator',
                    ],
                    [
                        'es' => [
                            'name' => 'Analista deportivo (Scouting)'
                        ],
                        'en' => [
                            'name' => 'Sports Analyst (Scouting)'
                        ],
                        'code' => 'scouting',
                    ],
                    [
                        'es' => [
                            'name' => 'Ojeador'
                        ],
                        'en' => [
                            'name' => 'Scout'
                        ],
                        'code' => 'scout',
                    ],
                    [
                        'es' => [
                            'name' => 'Ayudante / Asistente'
                        ],
                        'en' => [
                            'name' => 'Helper / Assistant'
                        ],
                        'code' => 'helper_assistant',
                    ],
                    [
                        'es' => [
                            'name' => 'Utillero'
                        ],
                        'en' => [
                            'name' => 'Utman'
                        ],
                        'code' => 'utman',
                    ],
                    [
                        'es' => [
                            'name' => 'Otro'
                        ],
                        'en' => [
                            'name' => 'Other'
                        ],
                        'code' => 'sport_other',
                    ],
                ],
            ],
            [
                'es' => [
                    'name' => 'Médica'
                ],
                'en' => [
                    'name' => 'medica'
                ],
                'code' => 'medica',
                'positions' => [
                    [
                        'es' => [
                            'name' => 'Director de servicios médicos'
                        ],
                        'en' => [
                            'name' => 'Director of medical services'
                        ],
                        'code' => 'medical_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Médico'
                        ],
                        'en' => [
                            'name' => 'Medical'
                        ],
                        'code' => 'medical',
                    ],
                    [
                        'es' => [
                            'name' => 'Fisioterapéuta'
                        ],
                        'en' => [
                            'name' => 'Physiotherapist'
                        ],
                        'code' => 'physiotherapist',
                    ],
                    [
                        'es' => [
                            'name' => 'Osteópata'
                        ],
                        'en' => [
                            'name' => 'Osteopath'
                        ],
                        'code' => 'osteopath',
                    ],
                    [
                        'es' => [
                            'name' => 'Masajista'
                        ],
                        'en' => [
                            'name' => 'Massage Therapist'
                        ],
                        'code' => 'masseuse',
                    ],
                    [
                        'es' => [
                            'name' => 'Nutricionista'
                        ],
                        'en' => [
                            'name' => 'Nutritionist'
                        ],
                        'code' => 'nutritionist',
                    ],
                    [
                        'es' => [
                            'name' => 'Podólogo'
                        ],
                        'en' => [
                            'name' => 'Chiropodist'
                        ],
                        'code' => 'chiropodist',
                    ],
                    [
                        'es' => [
                            'name' => 'Biomecánico'
                        ],
                        'en' => [
                            'name' => 'Biomechanical'
                        ],
                        'code' => 'biomechanical',
                    ],
                    [
                        'es' => [
                            'name' => 'Psicólogo'
                        ],
                        'en' => [
                            'name' => 'Psychologist'
                        ],
                        'code' => 'psychologist',
                    ],
                    [
                        'es' => [
                            'name' => 'Otro'
                        ],
                        'en' => [
                            'name' => 'Other'
                        ],
                        'code' => 'medical_other',
                    ],
                ],
            ],
            [
                'es' => [
                    'name' => 'Operativa e instalaciones'
                ],
                'en' => [
                    'name' => 'Operations and facilities'
                ],
                'code' => 'operations_and_facilities',
                'positions' => [
                    [
                        'es' => [
                            'name' => 'Director de operaciones'
                        ],
                        'en' => [
                            'name' => 'Operations director'
                        ],
                        'code' => 'operations_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Director de instalaciones'
                        ],
                        'en' => [
                            'name' => 'Facilities manager'
                        ],
                        'code' => 'facilities_manager',
                    ],
                    [
                        'es' => [
                            'name' => 'Director de seguridad'
                        ],
                        'en' => [
                            'name' => 'Security director'
                        ],
                        'code' => 'security_director',
                    ],
                    [
                        'es' => [
                            'name' => 'Encargado de mantenimiento'
                        ],
                        'en' => [
                            'name' => 'Maintenance manager'
                        ],
                        'code' => 'maintenance_manager',
                    ],
                    [
                        'es' => [
                            'name' => 'Otro'
                        ],
                        'en' => [
                            'name' => 'Other'
                        ],
                        'code' => 'operations_other',
                    ],
                ],
            ],
        ];
    }

    /**
     * @return void
     */
    protected function createJobArea($elements)
    {
        foreach ($elements as $elm) {
            $jobArea = $this->jobAreaRepository->create([
                'es' => $elm['es'],
                'en' => $elm['en'],
                'code' => $elm['code'],
            ]);

            foreach ($elm['positions'] as $position) {
                $position['jobs_area_id'] = $jobArea->id;
                $this->positionStaffRepository->create($position);
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createJobArea($this->get()->current());
    }
}
