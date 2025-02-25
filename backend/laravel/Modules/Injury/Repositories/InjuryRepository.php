<?php

namespace Modules\Injury\Repositories;

use App\Traits\TranslationTrait;
use App\Services\ModelRepository;
use Modules\Alumn\Entities\Alumn;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Player;
use Modules\Injury\Entities\Injury;
use Modules\Injury\Repositories\Interfaces\InjuryRepositoryInterface;

class InjuryRepository extends ModelRepository implements InjuryRepositoryInterface
{
    use TranslationTrait;

    /**
     * @var object
     */
    protected $model;

    public function __construct(Injury $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieve injuries with location group by severity and location
     * 
     * @param $entity name entity
     * @param $entity_id Id entity
     */
    public function getInjuriesLocation($entity, $entity_id)
    {
        return $this->model->where([
                'entity_type' => $this->resolvingClass($entity),
                'entity_id' => $entity_id
            ])
            ->groupBy('injury_location_id', 'injury_severity_id')
            ->get(['injury_severity_id', 'injury_location_id']);
    }

    /**
     * @return array of injury situations types
     */
    public function getInjurySituationTypes()
    {
        $injury_situations = Injury::getInjurySituationTypes();

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
        $affected_sides = Injury::getAffectedSideTypes();

        array_walk($affected_sides, function(&$value) {
            $value['code'] = $this->translator($value['code']);
        });

        return $affected_sides;
    }

    public function groupInjuryBySeverity($player_id)
    {
        $locale = app()->getLocale();

        $countRfdbySeverity = DB::table('injuries')
            ->select('injuries.injury_severity_id','injury_severity_translations.name',DB::raw("COUNT(*) as total"),)
            ->leftJoin('players', 'players.id', '=', 'injuries.entity_id')
            ->leftJoin('injury_severities', 'injuries.injury_severity_id', '=', 'injury_severities.id')
            ->leftJoin('injury_severity_translations', function($join) use ($locale){
                            $join->on('injury_severity_translations.injury_severity_id', '=', 'injury_severities.id');
                            $join->on('injury_severity_translations.locale','=',DB::raw("'".$locale."'"));
            })
            ->groupBy('players.id','injuries.injury_severity_id','injury_severity_translations.name')
            ->where('entity_id',$player_id)
            ->where('injuries.entity_type','=','Modules\Player\Entities\Player');

        return $countRfdbySeverity->get(); 
    }

    public function groupInjuryByType($player_id)
    {
        $locale = app()->getLocale();

        $countRfdbyType = DB::table('injuries')
            ->select('injuries.injury_type_spec_id','injury_type_spec_translations.name',DB::raw("COUNT(*) as total"),)
            ->leftJoin('players', 'players.id', '=', 'injuries.entity_id')
            ->leftJoin('injury_type_specs', 'injuries.injury_type_spec_id', '=', 'injury_type_specs.id')
            ->leftJoin('injury_type_spec_translations', function($join) use ($locale){
                            $join->on('injury_type_spec_translations.injury_type_spec_id', '=', 'injury_type_specs.id');
                            $join->on('injury_type_spec_translations.locale','=',DB::raw("'".$locale."'"));
            })
            ->groupBy('players.id','injuries.injury_type_spec_id','injury_type_spec_translations.name')
            ->where('entity_id',$player_id)
            ->where('injuries.entity_type','=','Modules\Player\Entities\Player');

        return $countRfdbyType->get(); 
    }

    public function groupInjuryByLocation($player_id)
    {
        $locale = app()->getLocale();

        $countRfdbyLocation = DB::table('injuries')
            ->select('injuries.injury_location_id','injury_location_translations.name',DB::raw("COUNT(*) as total"),)
            ->leftJoin('players', 'players.id', '=', 'injuries.entity_id')
            ->leftJoin('injury_locations', 'injuries.injury_location_id', '=', 'injury_locations.id')
            ->leftJoin('injury_location_translations', function($join) use ($locale){
                            $join->on('injury_location_translations.injury_location_id', '=', 'injury_locations.id');
                            $join->on('injury_location_translations.locale','=',DB::raw("'".$locale."'")); 
            })
            ->groupBy('players.id','injuries.injury_location_id','injury_location_translations.name')
            ->where('entity_id',$player_id)
            ->where('injuries.entity_type','=','Modules\Player\Entities\Player');

        return $countRfdbyLocation->get(); 
    }

    public function totalAbsenceByInjury($player_id)
    {
        $count_total_absence = DB::table('injuries')
        ->select(DB::raw(
                "SUM(extract(day from 
                    CASE 
                        WHEN injuries.competitively_discharged_at is NULL  THEN Now()
                        ELSE injuries.competitively_discharged_at
                        end 
                        - injuries.injury_date) ) as total
                ")
        )
        ->where('entity_id',$player_id)
        ->where('injuries.entity_type','=','Modules\Player\Entities\Player');
        return $count_total_absence->first();
    }

    private function resolvingClass($entity)
    {
        $class = [
            'alumn' => Alumn::class,
            'player' => Player::class
        ];

        return $class[$entity];
    }
}
