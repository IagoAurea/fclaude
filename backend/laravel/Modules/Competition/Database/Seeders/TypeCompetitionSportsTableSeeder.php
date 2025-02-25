<?php

namespace Modules\Competition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\TypeCompetitionRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\TypeCompetitionSportRepositoryInterface;

class TypeCompetitionSportsTableSeeder extends Seeder
{
    /**
     * @var $typeCompetitionSportRepository
     */
    protected $typeCompetitionSportRepository;
    
    /**
     * @var $sportRepository
     */
    protected $sportRepository;

    /**
     * @var $typeCompetitionRepository
     */
    protected $typeCompetitionRepository;

    /**
     * Instances a new seeder class.
     */
    public function __construct(
        TypeCompetitionSportRepositoryInterface $typeCompetitionSportRepository,
        SportRepositoryInterface $sportRepository, 
        TypeCompetitionRepositoryInterface $typeCompetitionRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->typeCompetitionRepository = $typeCompetitionRepository;
        $this->typeCompetitionSportRepository = $typeCompetitionSportRepository;
    }

     /**
     * @return void
     */
    protected function createTypeCompetitionSport()
    {
        $sports = $this->sportRepository->findAll();

        foreach($sports as $sport) {
            $types_competition = $this->getTypeCompetition($sport->code);

            foreach($types_competition as $code) {
                $type = $this->typeCompetitionRepository->findOneBy(['code' => $code]);
                
                $this->typeCompetitionSportRepository->create([
                    'sport_id' => $sport->id,
                    'type_competition_id' => $type->id
                ]);
            }
        }
    }

    /**
     * @return Array
     */
    private function getTypeCompetition($sport)
    {
        $type_competition_sport = [
            'football' => $this->typeCompetitionSportRepetitive(),
            'basketball' => $this->typeCompetitionSportRepetitive(),
            'handball' => $this->typeCompetitionSportRepetitive(),
            'indoor_soccer' => $this->typeCompetitionSportRepetitive(),
            'volleyball' => $this->typeCompetitionSportRepetitive(),
            'beach_volleyball' => $this->typeCompetitionSportRepetitive(),
            'roller_hockey' => $this->typeCompetitionSportRepetitive(),
            'field_hockey' => $this->typeCompetitionSportRepetitive(),
            'ice_hockey' => $this->typeCompetitionSportRepetitive(),
            'baseball' => $this->typeCompetitionSportRepetitive(),
            'waterpolo' => $this->typeCompetitionSportRepetitive(),
            'american_soccer' => $this->typeCompetitionSportRepetitive(),
            'tennis' => [
                'league_ranking', 'local_tournament', 'regional_tournament', 'provincial_tournament', 'national_tournament',
                'european_tournament', 'pan_american_tournament', 'south_american_tournament', 'asian_tournament', 'african_tournament',
                'world_tournament', 'olimpic_games', 'atp_tour_250', 'atp_tour_500', 'atp_tour_masters_1000', 'atp_world_tour_finals',
                'atp_challenger_series', 'itf_world_tennis_tour', 'davis_cup', 'grand_slam', 'other'
            ],
            'padel' => $this->typeCompetitionSportRepetitive(),
            'badminton' => $this->typeCompetitionSportRepetitive(),
            'swimming' => [
                'league_ranking', 'local_championship', 'regional_championship', 'provincial_championship',
                'national_championship', 'european_championship', 'pan_american_championship', 'south_american_championship',
                'asian_championship', 'african_championship', 'world_championship', 'olimpic_games', 'other'
            ],
            'rugby' => $this->typeCompetitionSportRepetitive(),
            'cricket' => $this->typeCompetitionSportRepetitive(),
        ];

        return $type_competition_sport[$sport] ?? [];
    }

     /**
     * Return type competition repetitive sport
     * @return Array
     */
    private function typeCompetitionSportRepetitive()
    {
        return [
            'league', 'cup', 'friendly'
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTypeCompetitionSport();
    }
}
