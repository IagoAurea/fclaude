<?php

namespace Modules\Training\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Training\Repositories\Interfaces\SubContentSessionRepositoryInterface;

class SubContentSesionsTableSeeder extends Seeder
{
   /**
     * @var object
     */
    protected $subContentSessionRepository;

    public function __construct(SubContentSessionRepositoryInterface $subContentSessionRepository)
    {
        $this->subContentSessionRepository = $subContentSessionRepository;
    }

    /**
     * @return void
     */
    protected function createSubContentSession(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->subContentSessionRepository->create($elm);
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
                    'name' => 'Técnica individual'
                ],
                'en' => [
                    'name' => 'Individual technique'
                ],
                'code' => 'individual_technique',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Técnica colectiva'
                ],
                'en' => [
                    'name' => 'Collective technique'
                ],
                'code' => 'collective_technique',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Ofensivos'
                ],
                'en' => [
                    'name' => 'Offensive'
                ],
                'code' => 'offensive_tecnica',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Defensivos'
                ],
                'en' => [
                    'name' => 'Defensive'
                ],
                'code' => 'defensive_tecnica',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Portero'
                ],
                'en' => [
                    'name' => 'Goalkeeper'
                ],
                'code' => 'defensive_tecnica',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Ofensivos'
                ],
                'en' => [
                    'name' => 'Offensive'
                ],
                'code' => 'offensive_tactica',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Defensivos'
                ],
                'en' => [
                    'name' => 'Defensive'
                ],
                'code' => 'defensive_tactica',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Portero'
                ],
                'en' => [
                    'name' => 'Goalkeeper'
                ],
                'code' => 'defensive_tactica',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'General'
                ],
                'en' => [
                    'name' => 'General'
                ],
                'code' => 'defensive_tactica',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Equipo ofensivo'
                ],
                'en' => [
                    'name' => 'Offensive team'
                ],
                'code' => 'offensive_team',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Equipo defensivo'
                ],
                'en' => [
                    'name' => 'Defensive team'
                ],
                'code' => 'defensive_team',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Equipos especiales'
                ],
                'en' => [
                    'name' => 'Special teams'
                ],
                'code' => 'special_teams',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Equipo ofensivo'
                ],
                'en' => [
                    'name' => 'Offensive team'
                ],
                'code' => 'offensive_team',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Equipo defensivo'
                ],
                'en' => [
                    'name' => 'Defensive team'
                ],
                'code' => 'defensive_team',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Equipos especiales'
                ],
                'en' => [
                    'name' => 'Special teams'
                ],
                'code' => 'special_teams',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Bateador'
                ],
                'en' => [
                    'name' => 'Batter'
                ],
                'code' => 'batter',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Lanzador (Pitcher)'
                ],
                'en' => [
                    'name' => 'Pitcher'
                ],
                'code' => 'pitcher',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Receptor (Catcher)'
                ],
                'en' => [
                    'name' => 'Catcher'
                ],
                'code' => 'catcher',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Jardinero'
                ],
                'en' => [
                    'name' => 'Fielder'
                ],
                'code' => 'fielder',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Bateador'
                ],
                'en' => [
                    'name' => 'Batter'
                ],
                'code' => 'batter',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Lanzador (Pitcher)'
                ],
                'en' => [
                    'name' => 'Pitcher'
                ],
                'code' => 'pitcher',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Receptor (Catcher)'
                ],
                'en' => [
                    'name' => 'Catcher'
                ],
                'code' => 'catcher',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Jardinero'
                ],
                'en' => [
                    'name' => 'Fielder'
                ],
                'code' => 'fielder',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Bateador (Batman)'
                ],
                'en' => [
                    'name' => 'Batman'
                ],
                'code' => 'batman',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Lanzador (Bowler)'
                ],
                'en' => [
                    'name' => 'Bowler'
                ],
                'code' => 'bowler',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Receptor (Wicket-Keeper)'
                ],
                'en' => [
                    'name' => 'Wicket-Keeper'
                ],
                'code' => 'wicket_keeper',
                'content_exercise_id' => 1,
            ],
            [
                'es' => [
                    'name' => 'Bateador (Batman)'
                ],
                'en' => [
                    'name' => 'Batman'
                ],
                'code' => 'batman',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Lanzador (Bowler)'
                ],
                'en' => [
                    'name' => 'Bowler'
                ],
                'code' => 'bowler',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Receptor (Wicket-Keeper)'
                ],
                'en' => [
                    'name' => 'Wicket-Keeper'
                ],
                'code' => 'wicket_keeper',
                'content_exercise_id' => 2,
            ],
            [
                'es' => [
                    'name' => 'Calentamiento'
                ],
                'en' => [
                    'name' => 'Warm up'
                ],
                'code' => 'warm_up',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Coordinación'
                ],
                'en' => [
                    'name' => 'Coordination'
                ],
                'code' => 'coordination',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Equilibrio'
                ],
                'en' => [
                    'name' => 'Balance'
                ],
                'code' => 'balance',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Propiocepción'
                ],
                'en' => [
                    'name' => 'Propioception'
                ],
                'code' => 'propioception',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Flexibilidad'
                ],
                'en' => [
                    'name' => 'Flexibility'
                ],
                'code' => 'flexibility',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Fuerza'
                ],
                'en' => [
                    'name' => 'Strength'
                ],
                'code' => 'strength',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Resistencia'
                ],
                'en' => [
                    'name' => 'Endurance'
                ],
                'code' => 'endurance',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Velocidad'
                ],
                'en' => [
                    'name' => 'Speed'
                ],
                'code' => 'speed',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Agilidad'
                ],
                'en' => [
                    'name' => 'Agility'
                ],
                'code' => 'agility',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Movilidad'
                ],
                'en' => [
                    'name' => 'Movility'
                ],
                'code' => 'movility',
                'content_exercise_id' => 3,
            ],
            [
                'es' => [
                    'name' => 'Recuperación'
                ],
                'en' => [
                    'name' => 'Recovery'
                ],
                'code' => 'recovery',
                'content_exercise_id' => 3,
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
        $this->createSubContentSession($this->get()->current());
    }
}
