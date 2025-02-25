<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Injury\Entities\PlayerInjury;
use Modules\Injury\Repositories\Interfaces\PlayerInjuryRepositoryInterface;
use App\Traits\TranslationTrait;

class PlayerInjuryRepository extends ModelRepository implements PlayerInjuryRepositoryInterface
{
    use TranslationTrait;

    /**
     * @var object
     */
    protected $model;

    public function __construct(PlayerInjury $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * @return array of injury situations types
     */
    public function getInjurySituationTypes()
    {
        $injury_situations = PlayerInjury::getInjurySituationTypes();

        array_walk($injury_situations, function(&$value) {
            $value['code'] = $this->translator($value['code']);
        });

        return $injury_situations;
    }

    /**
     * @return array of affected sides types
     */
    public function getAffectedSideTypes()
    {
        $affected_sides = PlayerInjury::getAffectedSideTypes();

        array_walk($affected_sides, function(&$value) {
            $value['code'] = $this->translator($value['code']);
        });

        return $affected_sides;
    }

    public function groupInjuryBySeverity($player_id)
    {
        $locale = app()->getLocale();

        $countRfdbySeverity = DB::table('player_injuries')
                            ->select('player_injuries.injury_severity_id','injury_severity_translations.name',DB::raw("COUNT(*) as total"),)
                            ->leftJoin('players', 'players.id', '=', 'player_injuries.player_id')
                            ->leftJoin('injury_severities', 'player_injuries.injury_severity_id', '=', 'injury_severities.id')
                            ->leftJoin('injury_severity_translations', function($join) use ($locale){
                                            $join->on('injury_severity_translations.injury_severity_id', '=', 'injury_severities.id');
                                            $join->on('injury_severity_translations.locale','=',DB::raw("'".$locale."'"));
                            })
                            ->groupBy('players.id','player_injuries.injury_severity_id','injury_severity_translations.name')
                            ->where('player_id',$player_id);

        return $countRfdbySeverity->get(); 
    }

    public function groupInjuryByType($player_id)
    {
        $locale = app()->getLocale();

        $countRfdbyType = DB::table('player_injuries')
                        ->select('player_injuries.injury_type_spec_id','injury_type_spec_translations.name',DB::raw("COUNT(*) as total"),)
                        ->leftJoin('players', 'players.id', '=', 'player_injuries.player_id')
                        ->leftJoin('injury_type_specs', 'player_injuries.injury_type_spec_id', '=', 'injury_type_specs.id')
                        ->leftJoin('injury_type_spec_translations', function($join) use ($locale){
                                        $join->on('injury_type_spec_translations.injury_type_spec_id', '=', 'injury_type_specs.id');
                                        $join->on('injury_type_spec_translations.locale','=',DB::raw("'".$locale."'"));
                        })
                        ->groupBy('players.id','player_injuries.injury_type_spec_id','injury_type_spec_translations.name')
                        ->where('player_id',$player_id);

        return $countRfdbyType->get(); 
    }

    public function groupInjuryByLocation($player_id)
    {
        $locale = app()->getLocale();

        $countRfdbyLocation = DB::table('player_injuries')
                            ->select('player_injuries.injury_location_id','injury_location_translations.name',DB::raw("COUNT(*) as total"),)
                            ->leftJoin('players', 'players.id', '=', 'player_injuries.player_id')
                            ->leftJoin('injury_locations', 'player_injuries.injury_location_id', '=', 'injury_locations.id')
                            ->leftJoin('injury_location_translations', function($join) use ($locale){
                                            $join->on('injury_location_translations.injury_location_id', '=', 'injury_locations.id');
                                            $join->on('injury_location_translations.locale','=',DB::raw("'".$locale."'")); 
                            })
                            ->groupBy('players.id','player_injuries.injury_location_id','injury_location_translations.name')
                            ->where('player_id',$player_id);

        return $countRfdbyLocation->get(); 
    }

    public function totalAbsenceByInjury($player_id)
    {
        $count_total_absence = DB::table('player_injuries')
        ->select(DB::raw("SUM(extract(day from 
                            CASE 
                                WHEN player_injuries.competitively_discharged_at is NULL  THEN Now()
                                ELSE player_injuries.competitively_discharged_at
                            end 
                            - player_injuries.injury_date) ) as total ")
        )
        ->where('player_id',$player_id);

        return $count_total_absence->first();
    }
}
