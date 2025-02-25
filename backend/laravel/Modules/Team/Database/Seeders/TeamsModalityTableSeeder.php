<?php

namespace Modules\Team\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Team\Repositories\Interfaces\TeamModalityRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;

class TeamsModalityTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $teamModalityRepository;

    /**
     * @var object
     */
    protected $sportRepository;

    public function __construct(
        TeamModalityRepositoryInterface $teamModalityRepository,
        SportRepositoryInterface $sportRepository
    )
    {
        $this->teamModalityRepository = $teamModalityRepository;
        $this->sportRepository = $sportRepository;
    }

    /**
     * @return void
     */
    protected function createTeamModality(array $elements)
    {
        foreach($elements as $elm)
        {
            $sport = $this->sportRepository->findOneBy(['code' => $elm['code']]);

            $modalities = $elm['modalities'];

            foreach($modalities as $modality)
            {
                $modality['sport_id'] = $sport->id;

                $this->teamModalityRepository->create($modality);
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
                'code' => 'football',
                'modalities' => [
                    [
                        'es' => [
                            'name' => 'Fútbol 7'
                        ],
                        'en' => [
                            'name' => 'Football 7'
                        ],
                        'code' => 'football_7'
                    ],
                    [
                        'es' => [
                            'name' => 'Fútbol 8'
                        ],
                        'en' => [
                            'name' => 'Football 8'
                        ],
                        'code' => 'football_8'
                    ],
                    [
                        'es' => [
                            'name' => 'Fútbol 9'
                        ],
                        'en' => [
                            'name' => 'Football 9'
                        ],
                        'code' => 'football_9'
                    ],
                    [
                        'es' => [
                            'name' => 'Fútbol 11'
                        ],
                        'en' => [
                            'name' => 'Football 11'
                        ],
                        'code' => 'football_11'
                    ],
                ]
            ],
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
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTeamModality($this->get()->current());
    }
}
