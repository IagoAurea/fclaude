<?php

namespace Modules\Competition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Competition\Repositories\Interfaces\TypeModalityMatchRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;

class TypeModalitiesMatchTableSeeder extends Seeder
{
     /**
     * @var object
     */
    protected $typeModalityMatchRepository;

    /**
     * @var object
     */
    protected $sportRepository;

    public function __construct(
        TypeModalityMatchRepositoryInterface $typeModalityMatchRepository,
        SportRepositoryInterface $sportRepository
    )
    {
        $this->typeModalityMatchRepository = $typeModalityMatchRepository;
        $this->sportRepository = $sportRepository;
    }

    /**
     * @return void
     */
    protected function createCompetitionMatchModality(array $elements)
    {
        foreach($elements as $elm)
        {
            $sport = $this->sportRepository->findOneBy(['code' => $elm['code']]);

            $modalities = $elm['modalities'];

            foreach($modalities as $modality)
            {
                $modality['sport_id'] = $sport->id;

                $this->typeModalityMatchRepository->create($modality);
            }
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'code' => 'badminton',
                'modalities' => [
                    [
                        'es' => [
                            'name' => 'Individual'
                        ],
                        'en' => [
                            'name' => 'Individual'
                        ],
                        'code' => 'individual'
                    ],
                    [
                        'es' => [
                            'name' => 'Doble'
                        ],
                        'en' => [
                            'name' => 'Double'
                        ],
                        'code' => 'double'
                    ],
                ]
            ],
            [
                'code' => 'tennis',
                'modalities' => [
                    [
                        'es' => [
                            'name' => 'Individual'
                        ],
                        'en' => [
                            'name' => 'Individual'
                        ],
                        'code' => 'individual'
                    ],
                    [
                        'es' => [
                            'name' => 'Doble'
                        ],
                        'en' => [
                            'name' => 'Double'
                        ],
                        'code' => 'double'
                    ],
                ]
            ],
            [
                'code' => 'padel',
                'modalities' => [
                    [
                        'es' => [
                            'name' => 'Individual'
                        ],
                        'en' => [
                            'name' => 'Individual'
                        ],
                        'code' => 'individual'
                    ],
                    [
                        'es' => [
                            'name' => 'Doble'
                        ],
                        'en' => [
                            'name' => 'Double'
                        ],
                        'code' => 'double'
                    ],
                ]
            ],
            [
                'code' => 'cricket',
                'modalities' => [
                    [
                        'es' => [
                            'name' => 'T10'
                        ],
                        'en' => [
                            'name' => 'T10'
                        ],
                        'code' => 't10'
                    ],
                    [
                        'es' => [
                            'name' => 'T20'
                        ],
                        'en' => [
                            'name' => 'T20'
                        ],
                        'code' => 't20'
                    ],
                    [
                        'es' => [
                            'name' => 'T30'
                        ],
                        'en' => [
                            'name' => 'T30'
                        ],
                        'code' => 't30'
                    ],
                    [
                        'es' => [
                            'name' => 'T40'
                        ],
                        'en' => [
                            'name' => 'T40'
                        ],
                        'code' => 't40'
                    ],
                    [
                        'es' => [
                            'name' => 'T50'
                        ],
                        'en' => [
                            'name' => 'T50'
                        ],
                        'code' => 't50'
                    ],
                    [
                        'es' => [
                            'name' => 'Nacional'
                        ],
                        'en' => [
                            'name' => 'National'
                        ],
                        'code' => 'national'
                    ],
                    [
                        'es' => [
                            'name' => 'Internacional'
                        ],
                        'en' => [
                            'name' => 'International'
                        ],
                        'code' => 'international'
                    ],
                    [
                        'es' => [
                            'name' => 'Un dia internacional (ODI)'
                        ],
                        'en' => [
                            'name' => 'One Day International (ODI)'
                        ],
                        'code' => 'one_day_international'
                    ],
                    [
                        'es' => [
                            'name' => 'Partido de prueba'
                        ],
                        'en' => [
                            'name' => 'Test match'
                        ],
                        'code' => 'test_match'
                    ],
                    [
                        'es' => [
                            'name' => 'Otro: Especificar'
                        ],
                        'en' => [
                            'name' => 'Other: Specify'
                        ],
                        'code' => 'other'
                    ],
                ]
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
        $this->createCompetitionMatchModality($this->get()->current());
    }
}
