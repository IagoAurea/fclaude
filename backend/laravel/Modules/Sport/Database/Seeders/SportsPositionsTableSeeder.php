<?php

namespace Modules\Sport\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportPositionRepositoryInterface;

class SportsPositionsTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $sportRepository;

    /**
     * @var object
     */
    protected $sportPositionRepository;

    /**
     * Instance a new seeder
     */
    public function __construct(SportRepositoryInterface $sportRepository, SportPositionRepositoryInterface $sportPositionRepository) {
        $this->sportRepository = $sportRepository;
        $this->sportPositionRepository = $sportPositionRepository;
    }

    /**
     * @return array
     */
    private function getPositions($code)
    {
        $positions = [
            'football' => [
                [
                    'es' => [
                        'name' => 'Portero'
                    ],
                    'en' => [
                        'name' => 'Goalkeeper'
                    ],
                    'code' => 'soccer_goalkeeper',
                ],
                [
                    'es' => [
                        'name' => 'Defensa'
                    ],
                    'en' => [
                        'name' => 'Defense'
                    ],
                    'code' => 'soccer_defense',
                ],
                [
                    'es' => [
                        'name' => 'Centrocampista'
                    ],
                    'en' => [
                        'name' => 'Midfielder'
                    ],
                    'code' => 'soccer_midfielder',
                ],
                [
                    'es' => [
                        'name' => 'Delantero'
                    ],
                    'en' => [
                        'name' => 'Forward'
                    ],
                    'code' => 'soccer_forward',
                ],
            ],
            'basketball' => [
                [
                    'es' => [
                        'name' => 'Base'
                    ],
                    'en' => [
                        'name' => 'Point Guard'
                    ],
                    'code' => 'basketball_point_guard',
                ],
                [
                    'es' => [
                        'name' => 'Escolta'
                    ],
                    'en' => [
                        'name' => 'Shooting Guard'
                    ],
                    'code' => 'basketball_shooting_guard',
                ],
                [
                    'es' => [
                        'name' => 'Alero'
                    ],
                    'en' => [
                        'name' => 'Small Forward'
                    ],
                    'code' => 'basketball_small_forward',
                ],
                [
                    'es' => [
                        'name' => 'Ala-Pívot'
                    ],
                    'en' => [
                        'name' => 'Power Forward'
                    ],
                    'code' => 'basketball_power_forward',
                ],
                [
                    'es' => [
                        'name' => 'Pívot'
                    ],
                    'en' => [
                        'name' => 'Center'
                    ],
                    'code' => 'basketball_center',
                ],
            ],
            'handball' => [
                [
                    'es' => [
                        'name' => 'Portero'
                    ],
                    'en' => [
                        'name' => 'Goalkeeper'
                    ],
                    'code' => 'handball_goalkeeper',
                ],
                [
                    'es' => [
                        'name' => 'Extremo'
                    ],
                    'en' => [
                        'name' => 'Winger'
                    ],
                    'code' => 'handball_winger',
                ],
                [
                    'es' => [
                        'name' => 'Lateral'
                    ],
                    'en' => [
                        'name' => 'Sider'
                    ],
                    'code' => 'handball_sider',
                ],
                [
                    'es' => [
                        'name' => 'Centro'
                    ],
                    'en' => [
                        'name' => 'Centre'
                    ],
                    'code' => 'handball_centre',
                ],
                [
                    'es' => [
                        'name' => 'Pivote'
                    ],
                    'en' => [
                        'name' => 'Pivot'
                    ],
                    'code' => 'handball_pivot',
                ],
                [
                    'es' => [
                        'name' => 'Avanzado'
                    ],
                    'en' => [
                        'name' => 'Advanced'
                    ],
                    'code' => 'handball_advanced',
                ],
            ],
            'indoor_soccer' => [
                [
                    'es' => [
                        'name' => 'Portero'
                    ],
                    'en' => [
                        'name' => 'Goalkeeper'
                    ],
                    'code' => 'indoor_soccer_goalkeeper',
                ],
                [
                    'es' => [
                        'name' => 'Cierre'
                    ],
                    'en' => [
                        'name' => 'Closer'
                    ],
                    'code' => 'indoor_soccer_closer',
                ],
                [
                    'es' => [
                        'name' => 'Ala Izquierda'
                    ],
                    'en' => [
                        'name' => 'Left Winger'
                    ],
                    'code' => 'indoor_soccer_left_winger',
                ],
                [
                    'es' => [
                        'name' => 'Ala Derecha'
                    ],
                    'en' => [
                        'name' => 'Right Winger'
                    ],
                    'code' => 'indoor_soccer_right_winger',
                ],
                [
                    'es' => [
                        'name' => 'Pivot'
                    ],
                    'en' => [
                        'name' => 'Pivot'
                    ],
                    'code' => 'indoor_soccer_pivot',
                ],
            ],
            'volleyball' => [
                [
                    'es' => [
                        'name' => 'Atacante o delantero'
                    ],
                    'en' => [
                        'name' => 'Hitter'
                    ],
                    'code' => 'volleyball_hitter',
                ],
                [
                    'es' => [
                        'name' => 'Zaguero o defensa'
                    ],
                    'en' => [
                        'name' => 'Blocker'
                    ],
                    'code' => 'volleyball_blocker',
                ],
                [
                    'es' => [
                        'name' => 'Líbero'
                    ],
                    'en' => [
                        'name' => 'Libero'
                    ],
                    'code' => 'volleyball_libero',
                ],
                [
                    'es' => [
                        'name' => 'Universal'
                    ],
                    'en' => [
                        'name' => 'Specialist'
                    ],
                    'code' => 'volleyball_specialist',
                ],
            ],
            'beach_volleyball' => [],
            'badminton' => [],
            'tennis' => [],
            'padel' => [],
            'roller_hockey' => [
                [
                    'es' => [
                        'name' => 'Portero'
                    ],
                    'en' => [
                        'name' => 'Goalkeeper'
                    ],
                    'code' => 'roller_hockey_goalkeeper',
                ],
                [
                    'es' => [
                        'name' => 'Defensa'
                    ],
                    'en' => [
                        'name' => 'Defense'
                    ],
                    'code' => 'roller_hockey_defense',
                ],
                [
                    'es' => [
                        'name' => 'Medio'
                    ],
                    'en' => [
                        'name' => 'Middle'
                    ],
                    'code' => 'roller_hockey_middle',
                ],
                [
                    'es' => [
                        'name' => 'Ala / Extremo'
                    ],
                    'en' => [
                        'name' => 'Winger'
                    ],
                    'code' => 'roller_hockey_winger',
                ],
                [
                    'es' => [
                        'name' => 'Forward'
                    ],
                    'en' => [
                        'name' => 'Delantero'
                    ],
                    'code' => 'roller_hockey_forward',
                ],
            ],
            'field_hockey' => [
                [
                    'es' => [
                        'name' => 'Portero'
                    ],
                    'en' => [
                        'name' => 'Goalkeeper'
                    ],
                    'code' => 'field_hockey_goalkeeper',
                ],
                [
                    'es' => [
                        'name' => 'Defensores Centrales'
                    ],
                    'en' => [
                        'name' => 'Full-backs'
                    ],
                    'code' => 'field_hockey_full_backs',
                ],
                [
                    'es' => [
                        'name' => 'Defensores Laterales'
                    ],
                    'en' => [
                        'name' => 'Half-backs'
                    ],
                    'code' => 'field_hockey_half_backs',
                ],
                [
                    'es' => [
                        'name' => 'Defensor Lateral Adelantado'
                    ],
                    'en' => [
                        'name' => 'Stopper'
                    ],
                    'code' => 'field_hockey_stopper',
                ],
                [
                    'es' => [
                        'name' => 'Libero'
                    ],
                    'en' => [
                        'name' => 'Sweeper'
                    ],
                    'code' => 'field_hockey_sweeper',
                ],
                [
                    'es' => [
                        'name' => 'Mediocampista'
                    ],
                    'en' => [
                        'name' => 'Insides'
                    ],
                    'code' => 'field_hockey_insides',
                ],
                [
                    'es' => [
                        'name' => 'Alas / Extremos'
                    ],
                    'en' => [
                        'name' => 'Wings'
                    ],
                    'code' => 'field_hockey_wings',
                ],
                [
                    'es' => [
                        'name' => 'Atacante Central'
                    ],
                    'en' => [
                        'name' => 'Centroforward'
                    ],
                    'code' => 'field_hockey_centroforward',
                ],
            ],
            'ice_hockey' => [
                [
                    'es' => [
                        'name' => 'Portero'
                    ],
                    'en' => [
                        'name' => 'Goalkeeper'
                    ],
                    'code' => 'ice_hockey_goalkeeper',
                ],
                [
                    'es' => [
                        'name' => 'Defensa'
                    ],
                    'en' => [
                        'name' => 'Defense'
                    ],
                    'code' => 'ice_hockey_defense',
                ],
                [
                    'es' => [
                        'name' => 'Ala / Extremo'
                    ],
                    'en' => [
                        'name' => 'Winger'
                    ],
                    'code' => 'ice_hockey_winger',
                ],
                [
                    'es' => [
                        'name' => 'Centro'
                    ],
                    'en' => [
                        'name' => 'Center'
                    ],
                    'code' => 'ice_hockey_center',
                ],
            ],
            'rugby' => [
                [
                    'es' => [
                        'name' => 'Primera línea'
                    ],
                    'en' => [
                        'name' => 'First row'
                    ],
                    'code' => 'rugby_first_row',
                ],
                [
                    'es' => [
                        'name' => 'Segunda línea'
                    ],
                    'en' => [
                        'name' => 'Second row'
                    ],
                    'code' => 'rugby_second_row',
                ],
                [
                    'es' => [
                        'name' => 'Tercera línea'
                    ],
                    'en' => [
                        'name' => 'Third row'
                    ],
                    'code' => 'rugby_third_row',
                ],
                [
                    'es' => [
                        'name' => 'Línea de tres cuartos'
                    ],
                    'en' => [
                        'name' => '3/4 row'
                    ],
                    'code' => 'rugby_quarters_row',
                ],
            ],
            'baseball' => [
                [
                    'es' => [
                        'name' => 'Bateador designado'
                    ],
                    'en' => [
                        'name' => 'Batter'
                    ],
                    'code' => 'baseball_batter',
                ],
                [
                    'es' => [
                        'name' => 'Lanzador'
                    ],
                    'en' => [
                        'name' => 'Pitcher'
                    ],
                    'code' => 'baseball_pitcher',
                ],
                [
                    'es' => [
                        'name' => 'Receptor'
                    ],
                    'en' => [
                        'name' => 'Catcher'
                    ],
                    'code' => 'baseball_catcher',
                ],
                [
                    'es' => [
                        'name' => 'Base'
                    ],
                    'en' => [
                        'name' => 'Baseman'
                    ],
                    'code' => 'baseball_baseman',
                ],
                [
                    'es' => [
                        'name' => 'Jardinero'
                    ],
                    'en' => [
                        'name' => 'Fielder'
                    ],
                    'code' => 'baseball_fielder',
                ],
            ],
            'cricket' => [
                [
                    'es' => [
                        'name' => 'Bateador'
                    ],
                    'en' => [
                        'name' => 'Batsman'
                    ],
                    'code' => 'cricket_batsman',
                ],
                [
                    'es' => [
                        'name' => 'Lanzador'
                    ],
                    'en' => [
                        'name' => 'Bowler'
                    ],
                    'code' => 'cricket_bowler',
                ],
                [
                    'es' => [
                        'name' => 'Receptor'
                    ],
                    'en' => [
                        'name' => 'Wicket keeper'
                    ],
                    'code' => 'cricket_Wicket',
                ],
                [
                    'es' => [
                        'name' => 'Jardineros'
                    ],
                    'en' => [
                        'name' => 'Fielders'
                    ],
                    'code' => 'cricket_fielders',
                ],
            ],
            'swimming' => [
                [
                    'es' => [
                        'name' => 'Crol'
                    ],
                    'en' => [
                        'name' => 'Crawl'
                    ],
                    'code' => 'swimming_crawl',
                ],
                [
                    'es' => [
                        'name' => 'Espalda'
                    ],
                    'en' => [
                        'name' => 'Backstroke'
                    ],
                    'code' => 'swimming_backstroke',
                ],
                [
                    'es' => [
                        'name' => 'Braza'
                    ],
                    'en' => [
                        'name' => 'Breaststroke'
                    ],
                    'code' => 'swimming_Breaststroke',
                ],
                [
                    'es' => [
                        'name' => 'Mariposa'
                    ],
                    'en' => [
                        'name' => 'Butterfly'
                    ],
                    'code' => 'swimming_butterfly',
                ], 
            ],
            'waterpolo' => [
                [
                    'es' => [
                        'name' => 'Portero'
                    ],
                    'en' => [
                        'name' => 'Goalkeeper / Goalie'
                    ],
                    'code' => 'waterpolo_goalkeeper',
                ],
                [
                    'es' => [
                        'name' => 'Boya / Pivote'
                    ],
                    'en' => [
                        'name' => 'Hole set / Center'
                    ],
                    'code' => 'waterpolo_hole_set',
                ],
                [
                    'es' => [
                        'name' => 'Extremo / Ala'
                    ],
                    'en' => [
                        'name' => 'Wing'
                    ],
                    'code' => 'waterpolo_wing',
                ],
                [
                    'es' => [
                        'name' => 'Lateral / Interior'
                    ],
                    'en' => [
                        'name' => 'Flat / Top wingng'
                    ],
                    'code' => 'waterpolo_flat',
                ],
                [
                    'es' => [
                        'name' => 'Central / Cubre boya'
                    ],
                    'en' => [
                        'name' => 'Point'
                    ],
                    'code' => 'waterpolo_point',
                ],
            ],
            'american_soccer' => [
                [
                    'es' => [
                        'name' => 'Posición defensiva'
                    ],
                    'en' => [
                        'name' => 'Defense position'
                    ],
                    'code' => 'american_soccer_defensive_position',
                ],
                [
                    'es' => [
                        'name' => 'Posición ofensiva'
                    ],
                    'en' => [
                        'name' => 'Offense position'
                    ],
                    'code' => 'american_soccer_offense_position',
                ],
                [
                    'es' => [
                        'name' => 'Posición especial'
                    ],
                    'en' => [
                        'name' => 'Special position'
                    ],
                    'code' => 'american_soccer_special_position',
                ],
            ]
        ];

        return $positions[$code] ?? [];
    }

    protected function createSportsPositions()
    {
        $sports = $this->sportRepository->findAll();

        foreach ($sports as $sport) {
            $positions = $this->getPositions($sport->code);

            foreach ($positions as $position) {
                $position['sport_id'] = $sport->id;

                $this->sportPositionRepository->create($position);
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
        $this->createSportsPositions();
    }
}
