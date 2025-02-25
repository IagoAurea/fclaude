<?php

namespace Modules\Sport\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportPositionRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportPositionSpecRepositoryInterface;

class SportPositionSpecTableSeeder extends Seeder
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
     * @var object
     */
    protected $sportPositionSpecRepository;


    /**
     * Instance a new seeder
     */
    public function __construct(
        SportRepositoryInterface $sportRepository,
        SportPositionSpecRepositoryInterface $sportPositionSpecRepository,
        SportPositionRepositoryInterface $sportPositionRepository
    ) {
        $this->sportRepository = $sportRepository;
        $this->sportPositionSpecRepository = $sportPositionSpecRepository;
        $this->sportPositionRepository = $sportPositionRepository;
    }


    /**
     * @return array
     */
    private function getPositions($code)
    {
        $positions = [
            'football' => [
                'soccer_defense' => [
                    [
                        'es' => [
                            'name' => 'Defensa central'
                        ],
                        'en' => [
                            'name' => 'Centre back'
                        ],
                        'code' => 'soccer_defense_centre',
                    ],
                    [
                        'es' => [
                            'name' => 'Defensa lateral derecho'
                        ],
                        'en' => [
                            'name' => 'Right back'
                        ],
                        'code' => 'soccer_defense_right_back',
                    ],
                    [
                        'es' => [
                            'name' => 'Defensa lateral izquierdo'
                        ],
                        'en' => [
                            'name' => 'Left back'
                        ],
                        'code' => 'soccer_defense_left_back',
                    ],
                    [
                        'es' => [
                            'name' => 'Carrillero derecho'
                        ],
                        'en' => [
                            'name' => 'Right line defender'
                        ],
                        'code' => 'soccer_defense_right_line',
                    ],
                    [
                        'es' => [
                            'name' => 'Carrillero izquierdo'
                        ],
                        'en' => [
                            'name' => 'Left line defender'
                        ],
                        'code' => 'soccer_defense_left_line',
                    ],
                    [
                        'es' => [
                            'name' => 'Líbero'
                        ],
                        'en' => [
                            'name' => 'Sweeper'
                        ],
                        'code' => 'soccer_defense_left_sweeper',
                    ],
                ],
                'soccer_midfielder' => [
                    [
                        'es' => [
                            'name' => 'Pivote / Centrocampista defensivo'
                        ],
                        'en' => [
                            'name' => 'Pivot / Defensive Midfielder'
                        ],
                        'code' => 'soccer_midfielder_defense',
                    ],
                    [
                        'es' => [
                            'name' => 'Interior derecho'
                        ],
                        'en' => [
                            'name' => 'Right inside'
                        ],
                        'code' => 'soccer_midfielder_right_inside',
                    ],
                    [
                        'es' => [
                            'name' => 'Interior izquierdo'
                        ],
                        'en' => [
                            'name' => 'Right left'
                        ],
                        'code' => 'soccer_midfielder_left_inside',
                    ],
                    [
                        'es' => [
                            'name' => 'Centrocampista organizador'
                        ],
                        'en' => [
                            'name' => 'Organizing midfielder'
                        ],
                        'code' => 'soccer_midfielder_organizing',
                    ],
                ],
                'soccer_forward' => [
                    [
                        'es' => [
                            'name' => 'Media punta'
                        ],
                        'en' => [
                            'name' => 'Half point'
                        ],
                        'code' => 'soccer_forward_half_point',
                    ],
                    [
                        'es' => [
                            'name' => 'Puntero derecho'
                        ],
                        'en' => [
                            'name' => 'Right striker'
                        ],
                        'code' => 'soccer_forward_right_striker',
                    ],
                    [
                        'es' => [
                            'name' => 'Puntero izquierdo'
                        ],
                        'en' => [
                            'name' => 'Left striker'
                        ],
                        'code' => 'soccer_forward_left_striker',
                    ],
                    [
                        'es' => [
                            'name' => 'Extremo derecho'
                        ],
                        'en' => [
                            'name' => 'Right winger'
                        ],
                        'code' => 'soccer_forward_right_winger',
                    ],
                    [
                        'es' => [
                            'name' => 'Extremo izquierdo'
                        ],
                        'en' => [
                            'name' => 'Left winger'
                        ],
                        'code' => 'soccer_forward_left_winger',
                    ],
                    [
                        'es' => [
                            'name' => 'Segundo delantero'
                        ],
                        'en' => [
                            'name' => 'Second forward'
                        ],
                        'code' => 'soccer_forward_second_forward',
                    ],
                    [
                        'es' => [
                            'name' => 'Delantero centro'
                        ],
                        'en' => [
                            'name' => 'Striker'
                        ],
                        'code' => 'soccer_forward_stiker',
                    ],
                    [
                        'es' => [
                            'name' => 'Falso 9'
                        ],
                        'en' => [
                            'name' => 'Fake Striker'
                        ],
                        'code' => 'soccer_forward_fake_stiker',
                    ],
                ]
            ],
            'basketball' => [],
            'indoor_soccer' => [],
            'volleyball' => [],
            'beach_volleyball' => [],
            'badminton' => [],
            'tennis' => [],
            'padel' => [],
            'cricket' => [],
            'swimming' => [],
            'roller_hockey' => [],
            'field_hockey' => [],
            'ice_hockey' => [],
            'rugby' => [
                'rugby_first_row' => [
                [
                    'es' => [
                        'name' => 'Pilar izquierdo'
                    ],
                    'en' => [
                        'name' => 'Left Prop'
                    ],
                    'code' => 'rugby_first_row_left_prop',
                ],
                [
                    'es' => [
                        'name' => 'Talonador'
                    ],
                    'en' => [
                        'name' => 'Hooker'
                    ],
                    'code' => 'rugby_first_row_hooker',
                ],
                [
                    'es' => [
                        'name' => 'Pilar derecho'
                    ],
                    'en' => [
                        'name' => 'Right Prop'
                    ],
                    'code' => 'rugby_first_row_right_prop',
                ],
                ],
                'rugby_second_row' => [
                    [
                        'es' => [
                            'name' => 'Segunda línea izquierdo'
                        ],
                        'en' => [
                            'name' => ' Left second row'
                        ],
                        'code' => 'rugby_second_row_left_second',
                    ],
                    [
                        'es' => [
                            'name' => 'Segunda línea derecho'
                        ],
                        'en' => [
                            'name' => 'Right second row'
                        ],
                        'code' => 'rugby_second_row_right_second',
                    ],
                    ], 
                    'rugby_third_row' => [
                        [
                            'es' => [
                                'name' => 'Tercera izquierdo / Flancos ciego'
                            ],
                            'en' => [
                                'name' => 'Left flanker'
                            ],
                            'code' => 'rugby_third_row_left_flanker',
                        ],
                        [
                            'es' => [
                                'name' => 'Tercera derecho / Flancos abierto'
                            ],
                            'en' => [
                                'name' => 'Right flanker'
                            ],
                            'code' => 'rugby_third_row_right_flanker',
                        ],
                        [
                            'es' => [
                                'name' => 'Número 8'
                            ],
                            'en' => [
                                'name' => 'Number 8'
                            ],
                            'code' => 'rugby_third_row_number_8',
                        ],
                    ], 
                        'rugby_quarters_row' => [
                            [
                                'es' => [
                                    'name' => 'Medio melé'
                                ],
                                'en' => [
                                    'name' => 'Scrum half'
                                ],
                                'code' => 'rugby_quarters_scrum_half',
                            ],
                            [
                                'es' => [
                                    'name' => 'Apertura '
                                ],
                                'en' => [
                                    'name' => 'Fly half'
                                ],
                                'code' => 'rugby_quarters_fly_half',
                            ],
                            [
                                'es' => [
                                    'name' => 'Ala izquierdo '
                                ],
                                'en' => [
                                    'name' => 'Left wing (ring wing)'
                                ],
                                'code' => 'rugby_quarters_wing',
                            ],
                            [
                                'es' => [
                                    'name' => 'Primer centro / Centro interior'
                                ],
                                'en' => [
                                    'name' => 'Inside center'
                                ],
                                'code' => 'rugby_quarters_inside_center',
                            ],
                            [
                                'es' => [
                                    'name' => 'Segundo centro / Centro exterior'
                                ],
                                'en' => [
                                    'name' => 'Outside center'
                                ],
                                'code' => 'rugby_quarters_outside_center',
                            ],
                            [
                                'es' => [
                                    'name' => 'Ala derecho '
                                ],
                                'en' => [
                                    'name' => 'Right wing'
                                ],
                                'code' => 'rugby_quarters_right_wing',
                            ],    
                            [
                                'es' => [
                                    'name' => 'Zaguero'
                                ],
                                'en' => [
                                    'name' => 'Fullback'
                                ],
                                'code' => 'rugby_quarters_fullback',
                            ], 
                        ], 
            ],
            
            'handball' => [],
            'baseball' => [
                'baseball_baseman' => [
                    [
                        'es' => [
                            'name' => 'Campocorto'
                        ],
                        'en' => [
                            'name' => 'Shortstop (SS)'
                        ],
                        'code' => 'baseball_baseman_shortstop',
                    ],
                    [
                        'es' => [
                            'name' => 'Primera base'
                        ],
                        'en' => [
                            'name' => 'First baseman (1B)'
                        ],
                        'code' => 'baseball_baseman_first_base',
                    ],
                    [
                        'es' => [
                            'name' => 'Segunda base'
                        ],
                        'en' => [
                            'name' => 'Second baseman (2B)'
                        ],
                        'code' => 'baseball_baseman_second_base',
                    ],
                    [
                        'es' => [
                            'name' => 'Tercera base'
                        ],
                        'en' => [
                            'name' => 'Third baseman (3B)'
                        ],
                        'code' => 'baseball_baseman_third_base',
                    ],
                ],
                'baseball_fielder' => [
                    [
                        'es' => [
                            'name' => 'Jardinero central'
                        ],
                        'en' => [
                            'name' => 'Center fielder (CF)'
                        ],
                        'code' => 'baseball_fielder_center',
                    ],
                    [
                        'es' => [
                            'name' => 'Jardinero izquierdo'
                        ],
                        'en' => [
                            'name' => 'Left fielder (LF)'
                        ],
                        'code' => 'baseball_fielder_left',
                    ],
                    [
                        'es' => [
                            'name' => 'Jardinero derecho'
                        ],
                        'en' => [
                            'name' => 'Right fielder (RF)'
                        ],
                        'code' => 'baseball_fielder_right',
                    ],
                ]
            ],
            'waterpolo' => [],
            'american_soccer' => [
                'american_soccer_defensive_position' => [
                    [
                        'es' => [
                            'name' => 'Placador defensivo'
                        ],
                        'en' => [
                            'name' => 'Defensive tackle'
                        ],
                        'code' => 'american_soccer_defensive_position_tackle',
                    ],
                    [
                        'es' => [
                            'name' => 'Ala defensivo'
                        ],
                        'en' => [
                            'name' => 'Defensive end'
                        ],
                        'code' => 'american_soccer_defensive_position_end',
                    ],
                    [
                        'es' => [
                            'name' => 'Back defensivo'
                        ],
                        'en' => [
                            'name' => 'Defensive back'
                        ],
                        'code' => 'american_soccer_defensive_position_back',
                    ],
                    [
                        'es' => [
                            'name' => 'Apoyador'
                        ],
                        'en' => [
                            'name' => 'Linebacker'
                        ],
                        'code' => 'american_soccer_defensive_position_linebacker',
                    ],
                    [
                        'es' => [
                            'name' => 'Esquinero'
                        ],
                        'en' => [
                            'name' => 'Cornerback'
                        ],
                        'code' => 'american_soccer_defensive_position_cornerback',
                    ],
                    [
                        'es' => [
                            'name' => 'Profundo'
                        ],
                        'en' => [
                            'name' => 'Safety'
                        ],
                        'code' => 'american_soccer_defensive_position_safety',
                    ],
                ],
                'american_soccer_offense_position' => [
                    [
                        'es' => [
                            'name' => 'Mariscal de campo'
                        ],
                        'en' => [
                            'name' => 'Quarteback'
                        ],
                        'code' => 'american_soccer_offense_position_quarterback',
                    ],
                    [
                        'es' => [
                            'name' => 'Corredor'
                        ],
                        'en' => [
                            'name' => 'Running back'
                        ],
                        'code' => 'american_soccer_offense_position_running_back',
                    ],
                    [
                        'es' => [
                            'name' => 'Ala abierta'
                        ],
                        'en' => [
                            'name' => 'Wide receiver'
                        ],
                        'code' => 'american_soccer_offense_position_wide_receiver',
                    ],
                    [
                        'es' => [
                            'name' => 'Ala cerrada'
                        ],
                        'en' => [
                            'name' => 'Tight end'
                        ],
                        'code' => 'american_soccer_offense_position_tight_end',
                    ],
                    [
                        'es' => [
                            'name' => 'Centro'
                        ],
                        'en' => [
                            'name' => 'Center'
                        ],
                        'code' => 'american_soccer_offense_position_center',
                    ],
                    [
                        'es' => [
                            'name' => 'Guardia ofensivo'
                        ],
                        'en' => [
                            'name' => 'Offensive guard'
                        ],
                        'code' => 'american_soccer_offense_position_offensive_guard',
                    ],
                    [
                        'es' => [
                            'name' => 'Placador ofensivo'
                        ],
                        'en' => [
                            'name' => 'Offensive tackle'
                        ],
                        'code' => 'american_soccer_offense_position_offensive_tackle',
                    ],
                    [
                        'es' => [
                            'name' => 'Corredor de poder'
                        ],
                        'en' => [
                            'name' => 'Fullback'
                        ],
                        'code' => 'american_soccer_offense_position_fullback',
                    ],
                    [
                        'es' => [
                            'name' => 'Corredor medio'
                        ],
                        'en' => [
                            'name' => 'Halfback'
                        ],
                        'code' => 'american_soccer_offense_position_halfback',
                    ],
                    [
                        'es' => [
                            'name' => 'Corredor profundo'
                        ],
                        'en' => [
                            'name' => 'Tailback'
                        ],
                        'code' => 'american_soccer_offense_position_tailback',
                    ],
                ],
                'american_soccer_special_position' => [
                    [
                        'es' => [
                            'name' => 'Pateador'
                        ],
                        'en' => [
                            'name' => 'Kicker'
                        ],
                        'code' => 'american_soccer_special_position_kicker',
                    ],
                    [
                        'es' => [
                            'name' => 'Sujetador'
                        ],
                        'en' => [
                            'name' => 'Holder'
                        ],
                        'code' => 'american_soccer_special_position_holder',
                    ],
                    [
                        'es' => [
                            'name' => 'Centro largo'
                        ],
                        'en' => [
                            'name' => 'Long Snapper'
                        ],
                        'code' => 'american_soccer_special_position_long_snapper',
                    ],
                    [
                        'es' => [
                            'name' => 'Retornador de patada'
                        ],
                        'en' => [
                            'name' => 'Kickoff or Punt returner'
                        ],
                        'code' => 'american_soccer_special_position_kickoff',
                    ],
                    [
                        'es' => [
                            'name' => 'Artillero'
                        ],
                        'en' => [
                            'name' => 'Gunner'
                        ],
                        'code' => 'american_soccer_special_position_gunner',
                    ],
                    [
                        'es' => [
                            'name' => 'Despejador'
                        ],
                        'en' => [
                            'name' => 'Wedge buster'
                        ],
                        'code' => 'american_soccer_special_position_wedge_buster',
                    ],
                    [
                        'es' => [
                            'name' => 'Equipo de manos'
                        ],
                        'en' => [
                            'name' => 'Hands team'
                        ],
                        'code' => 'american_soccer_special_position_hands_team',
                    ],
                ],
            ],
        ];

        return $positions[$code] ?? [];
    }


    /**
     * Stores all positions specs
     * 
     * @return void
     */
    public function createPositionSpecs()
    {
        $sports = $this->sportRepository->findAll();

        foreach($sports as $sport) {
            $positions = $this->getPositions($sport->code);

            if (count($positions) > 0) {
                foreach($positions as $positionCode => $positionSpecs) {
                    $position = $this->sportPositionRepository->findOneBy([
                        'code' => $positionCode
                    ]);

                    foreach($positionSpecs as $spec) {
                        $spec['sport_position_id'] = $position->id;

                        $this->sportPositionSpecRepository->create($spec);
                    }
                }
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
        $this->createPositionSpecs();
    }
}
