<?php

namespace Modules\Injury\Repositories;

use Exception;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Player;
use Modules\Injury\Entities\InjuryRfd;
use Modules\Injury\Repositories\Interfaces\InjuryRfdRepositoryInterface;

class InjuryRfdRepository extends ModelRepository implements InjuryRfdRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'injury_rfds';

    /**
     * @var object
    */
    protected $model;

    public function __construct(InjuryRfd $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function allInjuriesRfdByPlayer($player_id)
    {
        return $this->model
            ->whereHas('injury', function($query) use($player_id) {
                $query->where('entity_id', $player_id)
                ->where('entity_type', Player::class);
            })
            ->get();
    }

    /**
     * Retrieve the RDF with all relations
     *
     * @param Int $rfd_id Identifier of the rfd
     *
     * @return array
     */
    public function getRfdAll($rfd_id)
    {
        $relations = $this->getModelRelations();

        $rfd = $this->model
            ->with($relations)
            ->where('id', $rfd_id)
            ->first();

        if (!$rfd) {
            throw new Exception("Rfd not found");
        }

        $rfd->phase_details->makeHidden([
            'phase_id', 'injury_rfd_id', 'professional_directs_id', 'current_situation_id'
        ]);

        return $rfd;
    }

    /**
     * Function to retrieve RFD Advance
     *
     * @param Int $rfd_id Identifier of the rfd
     *
     * @return Array
     */
    public function getRfdAdvance($rfd_id)
    {

        $rfdAdvance =  DB::table('injury_rfds')
                        ->select('injuries.injury_date',
                                DB::raw("extract(day from NOW() - injuries.injury_date)  as days_passed"),
                                'injury_rfds.percentage_complete',
                                DB::raw("(select pd.percentage_complete as percentage_psychological from phase_details pd 
                                        left join phases p on pd.phase_id = p.id
                                        where pd.injury_rfd_id = injury_rfds.id
                                        and p.code like '%psychological%') as percentage_psychological"),
                                DB::raw("(select sum((pd2.percentage_complete * p2.percentage_value) / 100 ) as percentage_fisical from phase_details pd2 
                                        left join phases p2 on pd2.phase_id = p2.id
                                        where pd2.injury_rfd_id = injury_rfds.id
                                        and p2.code != 'psychological')  as percentage_fisical"),
                        )
                        ->leftJoin('injuries', 'injuries.id', '=', 'injury_rfds.injury_id')
                        ->where('injury_rfds.id', $rfd_id);

        return $rfdAdvance->get();
    }

    /**
     * function to retrieve list of player by rfd
     *
     * @return Array
     */
    public function listOfPlayersByRfd($teamId, $search, $order, $filter)
    {
        $locale = app()->getLocale();

        $conditionsWhere = [];
        $conditionsOrWhere = [];
        $conditionsOrWhere2 = [];

        if (is_null($order)) {
            $order = 'ASC';
        }

        if (!is_null($search) && trim($search) != "") {
            $conditionsWhere[] = [
                DB::raw('LOWER(injury_type_spec_translations.name)'), 'LIKE', '%' . strtolower(rtrim($search)) . '%'
            ];
            $conditionsOrWhere[] = [
                DB::raw('LOWER(injury_location_translations.name)'), 'LIKE', '%'.strtolower(rtrim($search)).'%'
            ];
            $conditionsOrWhere2[] = [
                DB::raw('LOWER(injury_severity_translations.name)'), 'LIKE', '%'.strtolower(rtrim($search)).'%'
            ];
        }

        if (!is_null($filter)) {
            $conditionsWhere[] = $filter;
        }

        $listPlayersByRdf =
            DB::table('players')
                ->select('players.id as player_id','players.full_name', 'players.gender_id',
                    DB::raw("
                        (CASE
                            WHEN players.gender_id = '1' THEN 'male'
                            WHEN players.gender_id = '2' THEN 'female'
                            ELSE 'undefined'
                        END) AS gender
                    "),
                    DB::raw("resources_player.url as player_url"),
                    DB::raw("resources.url as injury_type_spec_image"),
                    DB::raw("injuries.is_active as injury_status"),
                    DB::raw("injuries.injury_date as injury_date"),
                    DB::raw("injury_type_spec_translations.name as type_injury"),
                    DB::raw("injury_location_translations.name as injury_location"),
                    DB::raw("injury_severity_translations.name as injury_severity"),
                    DB::raw("injury_rfds.id as id_rfd"),
                    DB::raw("injury_rfds.code as code_rfd"),
                    DB::raw("injury_rfds.closed as closed_rfd"))
                ->leftJoin('injuries', 'players.id', '=', 'injuries.entity_id')
                ->leftJoin('injury_type_specs', 'injuries.injury_type_spec_id', '=', 'injury_type_specs.id')
                ->leftJoin('injury_type_spec_translations', function ($join) use ($locale){
                    $join->on('injury_type_spec_translations.injury_type_spec_id', '=', 'injury_type_specs.id');
                    $join->on('injury_type_spec_translations.locale','=',DB::raw("'".$locale."'"));
                })
                ->leftJoin('resources as resources_player', 'players.image_id', '=', 'resources_player.id')
                ->leftJoin('resources', 'injury_type_specs.image_id', '=', 'resources.id')
                ->leftJoin('injury_locations', 'injuries.injury_location_id', '=', 'injury_locations.id')
                ->leftJoin('injury_location_translations', function ($join) use ($locale){
                                $join->on(
                                    'injury_location_translations.injury_location_id', '=', 'injury_locations.id'
                                );
                                $join->on(
                                    'injury_location_translations.locale','=',DB::raw("'".$locale."'")
                                );
                })
                ->leftJoin('injury_severities', 'injuries.injury_severity_id', '=', 'injury_severities.id')
                ->leftJoin('injury_severity_translations', function($join) use ($locale){
                                $join->on(
                                    'injury_severity_translations.injury_severity_id', '=', 'injury_severities.id'
                                );
                                $join->on(
                                    'injury_severity_translations.locale','=',DB::raw("'".$locale."'")
                                );
                })
                ->rightJoin('injury_rfds', 'injuries.id', '=', 'injury_rfds.injury_id')
                ->where('players.team_id', $teamId)
                ->whereNull('injury_rfds.deleted_at')
                ->whereNull('players.deleted_at')
                ->where(function ($q) use ($conditionsWhere,  $conditionsOrWhere , $conditionsOrWhere2) {
                    $q->where( $conditionsWhere)
                      ->orWhere($conditionsOrWhere)
                      ->orWhere($conditionsOrWhere2);
                });

        $idsPlayersByRfd = $listPlayersByRdf->pluck('player_id');
        
        $listPlayersWithOutRdf =
            DB::table('players')
                ->select('players.id as player_id','players.full_name', 'players.gender_id',
                    DB::raw("
                        (CASE
                            WHEN players.gender_id = '1' THEN 'male'
                            WHEN players.gender_id = '2' THEN 'female'
                            ELSE 'undefined'
                        END) AS gender
                    "),
                    DB::raw("resources_player.url as player_url"),
                    DB::raw("NULL as injury_status"), DB::raw("NULL as injury_date"),
                    DB::raw("NULL as injury_type_spec_image"),
                    DB::raw("NULL as type_injury"), DB::raw("NULL as injury_location"),
                    DB::raw("NULL as injury_severity"), DB::raw("NULL as id_rfd"),
                    DB::raw("NULL as code_rfd"), DB::raw("NULL as closed_rfd"))
                ->leftJoin('resources as resources_player', 'players.image_id', '=', 'resources_player.id')
                ->where('players.team_id', $teamId)
                ->whereNull('players.deleted_at')
                ->whereNotIn('players.id', $idsPlayersByRfd);
            
        return  $listPlayersByRdf->union($listPlayersWithOutRdf)
            ->orderBy('full_name', $order)
            ->get();
    }

    /**
     * Private function to retrieve needed model relations in order to not to repeat
     * the same code on every query sent
     *
     * @return Array
     */
    private function getModelRelations()
    {
        $locale = app()->getLocale();

        return [
            'injury' => function ($query) use ($locale) {
                $query->select('id', 'entity_id', 'entity_type', 'injury_date',
                    'extra_info', 'medically_discharged_at', 'sportly_discharged_at',
                    'competitively_discharged_at', 'injury_type_id', 'injury_type_spec_id',
                    'injury_severity_id')
                ->with(['typeSpec' => function ($query) use ($locale) {
                    $query->with(['image' => function ($query) {
                        $query->select('url', 'size', 'id', 'mime_type');
                    }])
                    ->withTranslation($locale);
                }])
                ->with(['entity', 'type', 'severity']);
            },
            'phase_details'=> function ($query) use ($locale) {
                $query->select('*')
                ->with(['phase' => function ($query) use ($locale) {
                    $query->select('*')
                    ->withTranslation($locale);
                },'current_situation','professional_direct'])
                ->orderBy('id', 'ASC');
            },
            'criterias' => function ($query) use ($locale) {
                $query
                ->withPivot('value')
                ->withTranslation($locale);
            },
            'daily_works'
        ];
    }

}