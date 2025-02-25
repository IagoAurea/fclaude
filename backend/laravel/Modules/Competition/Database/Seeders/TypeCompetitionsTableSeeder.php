<?php

namespace Modules\Competition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Competition\Repositories\Interfaces\TypeCompetitionRepositoryInterface;

class TypeCompetitionsTableSeeder extends Seeder
{
    /**
     * repository
     * @var $typeCompetitionRepository
     */
    protected $typeCompetitionRepository;

    /**
     * TypeCompetitionsTableSeeder constructor.
     * @param TypeCompetitionRepositoryInterface $typeCompetitionRepository
     */
    public function __construct(TypeCompetitionRepositoryInterface $typeCompetitionRepository)
    {
        $this->typeCompetitionRepository = $typeCompetitionRepository;
    }

    /**
     * Method create weathers
     * @param array $elements
     * @return void
     */
    protected function createTypeCompetitions($elements)
    {
        foreach ($elements as $element)
        {
            $this->typeCompetitionRepository->create($element);
        }
    }

    /**
     * @return \Generator
     */
    private function get()
    {
        yield [
            [
                'es' => [ 'name' => 'Liga'],
                'en' => [ 'name' => 'League'],
                'code' => 'league'
            ],
            [
                'es' => [ 'name' => 'Copa'],
                'en' => [ 'name' => 'Cup'],
                'code' => 'cup'
            ],
            [
                'es' => [ 'name' => 'Amistoso'],
                'en' => [ 'name' => 'Friendly'],
                'code' => 'friendly'
            ],
            [
                'es' => [ 'name' => 'Liga regular (Ranking)'],
                'en' => [ 'name' => 'League (Ranking)'],
                'code' => 'league_ranking'
            ],
            [
                'es' => [ 'name' => 'Campeonato Local'],
                'en' => [ 'name' => 'Local Championship'],
                'code' => 'local_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Regional'],
                'en' => [ 'name' => 'Regional Championship'],
                'code' => 'regional_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Provincial'],
                'en' => [ 'name' => 'Provincial Championship'],
                'code' => 'provincial_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Nacional'],
                'en' => [ 'name' => 'National Championship'],
                'code' => 'national_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Europeo'],
                'en' => [ 'name' => 'European Championship'],
                'code' => 'european_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Panamericano'],
                'en' => [ 'name' => 'Pan American Championship'],
                'code' => 'pan_american_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Sudamericano'],
                'en' => [ 'name' => 'South American Championship'],
                'code' => 'south_american_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Asiático'],
                'en' => [ 'name' => 'Asian Championship'],
                'code' => 'asian_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Africano'],
                'en' => [ 'name' => 'African Championship'],
                'code' => 'african_championship'
            ],
            [
                'es' => [ 'name' => 'Campeonato Mundial'],
                'en' => [ 'name' => 'World Championship'],
                'code' => 'world_championship'
            ],
            [
                'es' => [ 'name' => 'Juegos Olímpicos'],
                'en' => [ 'name' => 'Olimpic Games'],
                'code' => 'olimpic_games'
            ],
            [
                'es' => [ 'name' => 'Otros'],
                'en' => [ 'name' => 'Other'],
                'code' => 'other'
            ],            
            [
                'es' => [ 'name' => 'Torneo Local'],
                'en' => [ 'name' => 'Local Tournament'],
                'code' => 'local_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Regional'],
                'en' => [ 'name' => 'Regional Tournament'],
                'code' => 'regional_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Provincial'],
                'en' => [ 'name' => 'Provincial Tournament'],
                'code' => 'provincial_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Nacional'],
                'en' => [ 'name' => 'National Tournament'],
                'code' => 'national_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Europeo'],
                'en' => [ 'name' => 'European Tournament'],
                'code' => 'european_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Panamericano'],
                'en' => [ 'name' => 'Pan American Tournament'],
                'code' => 'pan_american_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Sudamericano'],
                'en' => [ 'name' => 'South American Tournament'],
                'code' => 'south_american_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Asiático'],
                'en' => [ 'name' => 'Asian Tournament'],
                'code' => 'asian_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Africano'],
                'en' => [ 'name' => 'African Tournament'],
                'code' => 'african_tournament'
            ],            
            [
                'es' => [ 'name' => 'Torneo Mundial'],
                'en' => [ 'name' => 'World Tournament'],
                'code' => 'world_tournament'
            ],            
            [
                'es' => [ 'name' => 'Juegos Olímpicos'],
                'en' => [ 'name' => 'Olimpic Games'],
                'code' => 'olimpic_games'
            ],            
            [
                'es' => [ 'name' => 'ATP Tour 250'],
                'en' => [ 'name' => 'ATP Tour 250'],
                'code' => 'atp_tour_250'
            ],            
            [
                'es' => [ 'name' => 'ATP Tour 500'],
                'en' => [ 'name' => 'ATP Tour 500'],
                'code' => 'atp_tour_500'
            ],            
            [
                'es' => [ 'name' => 'ATP Tour Masters 1000'],
                'en' => [ 'name' => 'ATP Tour Masters 1000'],
                'code' => 'atp_tour_masters_1000'
            ],            
            [
                'es' => [ 'name' => 'ATP World Tour Finals'],
                'en' => [ 'name' => 'ATP World Tour Finals'],
                'code' => 'atp_world_tour_finals'
            ],            
            [
                'es' => [ 'name' => 'ATP Challenger Series'],
                'en' => [ 'name' => 'ATP Challenger Series'],
                'code' => 'atp_challenger_series'
            ],            
            [
                'es' => [ 'name' => 'ITF World Tennis Tour'],
                'en' => [ 'name' => 'ITF World Tennis Tour'],
                'code' => 'itf_world_tennis_tour'
            ],            
            [
                'es' => [ 'name' => 'Copa Davis'],
                'en' => [ 'name' => 'Davis Cup'],
                'code' => 'davis_cup'
            ],            
            [
                'es' => [ 'name' => 'Grand Slam'],
                'en' => [ 'name' => 'Grand Slam'],
                'code' => 'grand_slam'
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
        $this->createTypeCompetitions($this->get()->current());
    }
}
