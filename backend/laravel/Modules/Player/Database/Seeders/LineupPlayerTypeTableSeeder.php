<?php

namespace Modules\Player\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Player\Repositories\Interfaces\LineupPlayerTypeRepositoryInterface;

class LineupPlayerTypeTableSeeder extends Seeder
{
    /**
     * @var $lineupPlayerTypeRepository
     */
    protected $lineupPlayerTypeRepository;

    /**
     * @var $sportRepository
     */
    protected $sportRepository;


    public function __construct(
        SportRepositoryInterface $sportRepository,
        LineupPlayerTypeRepositoryInterface $lineupPlayerTypeRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->lineupPlayerTypeRepository = $lineupPlayerTypeRepository;
    }

    /**
     * @return void
     */
    protected function createTypePlayer()
    {
        $sports = $this->sportRepository->findAll();

        foreach($sports as $sport) {
            $lineups = $this->getLineups($sport->code);

            if (count($lineups) == 0) { continue; }

            foreach($lineups as $lineup) {
                $lineup['sport_id'] = $sport->id;

                $this->lineupPlayerTypeRepository->create($lineup);
            }
        }
    }

    /**
     * @return Array
     */
    private function getLineups($sport)
    {
        $lineups = [
            'football' => $this->lineupSportRepetitive(),
            'basketball' => $this->lineupSportRepetitive(),
            'handball' => $this->lineupSportRepetitive(),
            'indoor_soccer' => $this->lineupSportRepetitive(),
            'volleyball' => $this->lineupSportRepetitive(),
            'beach_volleyball' => $this->lineupSportRepetitive(),
            'roller_hockey' => $this->lineupSportRepetitive(),
            'field_hockey' => $this->lineupSportRepetitive(),
            'ice_hockey' => $this->lineupSportRepetitive(),
            'baseball' => [
                [ 'es' => [ 'name' => 'Catcher'], 'en' => [ 'name' => 'catcher'], 'code' => 'catcher', 'color' => '#00e9c5'],
                [ 'es' => [ 'name' => 'Pitcher' ], 'en' => [ 'name' => 'pitcher' ], 'code' => 'pitcher', 'color' => '#FF0080' ],
                [ 'es' => [ 'name' => '1ERA Base' ], 'en' => [ 'name' => '1B Base' ], 'code' => 'first_baseman', 'color' => '#024CAC' ],
                [ 'es' => [ 'name' => '2DA Base' ], 'en' => [ 'name' => '2B Base' ], 'code' => 'second_baseman', 'color' => '#00FF00' ],
                [ 'es' => [ 'name' => 'Campo corto' ], 'en' => [ 'name' => 'Shortstop' ], 'code' => 'shortstop', 'color' => '#FF8000' ],
                [ 'es' => [ 'name' => '3RA Base' ], 'en' => [ 'name' => '3B Base' ], 'code' => 'third_baseman', 'color' => '#FFFF00' ],
                [ 'es' => [ 'name' => 'Jardinero Derecho' ], 'en' => [ 'name' => 'Fielder Left' ], 'code' => 'fielder_left', 'color' => '#FF4A4A' ],
                [ 'es' => [ 'name' => 'Jardinero Central' ], 'en' => [ 'name' => 'Fielder Center' ], 'code' => 'fielder_center', 'color' => '#00FFFF' ],
                [ 'es' => [ 'name' => 'Jardinero Izquierdo' ], 'en' => [ 'name' => 'Fielder Left' ], 'code' => 'fielder_left', 'color' => '#D9F10A' ],
                [ 'es' => [ 'name' => 'Bateador designado' ], 'en' => [ 'name' => 'Batter' ], 'code' => 'batter', 'color' => '#2196f3' ],
                [ 'es' => [ 'name' => 'Suplente' ], 'en' => [ 'name' => 'Substitutes' ], 'code' => 'substitutes', 'color' => '#A4A4A4' ],
            ],
            'waterpolo' => $this->lineupSportRepetitive(),
            'american_soccer' => $this->lineupSportRepetitive(),
            'tennis' => $this->lineupSportRepetitive(),
            'padel' => $this->lineupSportRepetitive(),
            'badminton' => $this->lineupSportRepetitive(),
            'swimming' => $this->lineupSportRepetitive(),
            'rugby' => $this->lineupSportRepetitive(),
            'cricket' => $this->lineupSportRepetitive(),
        ];

        return $lineups[$sport] ?? [];
    }

    /**
     * Return lineup repetitive sport
     */
    private function lineupSportRepetitive()
    {
        return [
            [ 'es' => [ 'name' => 'Titulares'], 'en' => [ 'name' => 'Starting'], 'code' => 'starting', 'color' => '#00e9c5' ],
            [ 'es' => [ 'name' => 'Suplentes' ], 'en' => [ 'name' => 'Substitutes' ], 'code' => 'substitutes', 'color' => '#A4A4A4'],
            [ 'es' => [ 'name' => 'Capitán' ], 'en' => [ 'name' => 'Captain'], 'code' => 'team_captain', 'color' => '#2196f3' ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTypePlayer();
    }
}
