<?php

namespace Modules\Team\Repositories;

use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Team\Entities\Team;
use Modules\Player\Entities\Player;
use App\Services\ModelRepository;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\DB;
use Modules\Team\Entities\TeamStaff;

class TeamRepository extends ModelRepository implements TeamRepositoryInterface
{
	use TranslationTrait;

	/**
     * @var object
    */
    protected $model;

    public function __construct(Team $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieve all teams with players by user create
     */
    public function getAllTeamsWithPlayersByUser($user_id)
    {
        return $this->model
                ->with('players')
                ->where('user_id', $user_id)
                ->orderBy("name", "ASC")
                ->get();
    }

    /**
     * @return array Returns an array of gender
     */
    public function getGenderTypes()
    {
        $genders = Team::getGenderTypes();

        array_walk($genders, function(&$value) {
            $value['code'] = $this->translator($value['code']);
        });

        return $genders;
    }

    /**
     * @param int $id
     * @return array
     * Returns teams by owner
     */
    public function findAllByOwner($id, $request, $clubId = null, $teamsId = [])
    {
        $query = $this->model->with('type', 'sport', 'season');

        $query->when(isset($request->sport_id), function ($q) use ($request) {
            $q->where('sport_id', $request->sport_id);
        });
        
        $query->when(isset($clubId), function ($q) use ($clubId) {
            $q->where('club_id', $clubId);
        });

        $query->when(count($teamsId) > 0, function ($q) use ($teamsId) {
            $q->whereIn('id', $teamsId);
        });

        $query->when(!isset($clubId), function ($q) use ($id) {
            $q->whereHas('club', function ($query) use ($id) {
                $query->where('user_id', $id);
            });
        });

        return $query->orderBy('name', 'ASC')->get();
    }

    /**
     * @param int $team_id
     * @return int
     * Returns count
     */
    public function countMembers($team_id)
    {
        return Player::where('team_id', $team_id)->count();
    }

    /**
     * @param int $team_id
     * @return array
     * Returns lis of players by team
     */
    public function findAllPlayersByTeam($team_id)
    {
        $listOfPlayers = Player::select('id','full_name','position_id')
        ->where('team_id',$team_id)
        ->with('position')
        ->get();

        $listOfPlayers->makeHidden('laterality');
        $listOfPlayers->makeHidden('gender');
        $listOfPlayers->makeHidden('max_heart_rate');
        $listOfPlayers->makeHidden('age');
        $listOfPlayers->makeHidden('bmi');
        $listOfPlayers->makeHidden('position_id');

        return $listOfPlayers;
    }

    /**
     * @param int $team_id
     * @return object
     * Returns team
     */
    public function findTeamById($team_id)
    {
        $relations = $this->getModelRelations();

        $query = $this->model
                    ->with($relations)
                    ->where('id',$team_id)
                    ->first();
        
       $query->makeHidden('modality_id');
       $query->makeHidden('season_id');
       $query->makeHidden('image_id');
       $query->makeHidden('cover_id');
       $query->makeHidden('type_id');
       $query->makeHidden('sport_id');
       $query->makeHidden('club_id');

        return $query;
    }

    /**
     * It returns a list of injuries for a given team.
     * </code>
     *
     * @param team The team object
     *
     * @return A collection of objects.
     */
    public function listTeamRDFInjuries($team)
    {
        $locale = app()->getLocale();

        $query = DB::table('players')->select(
            'injury_rfds.id AS injury_rfd_id',
            'players.id AS player_id',
            'players.team_id',
            'players.full_name AS player_name',
            'injuries.id AS injury_id',
            'injuries.injury_date',
            'injuries.detailed_location',
            'injuries.is_active',
            'injuries.entity_type',
            'current_situations.id',
            'current_situation_translations.name AS current_situation'
        )->leftJoin(
            'injuries', 'players.id', '=', 'injuries.entity_id'
        )->leftJoin(
            'injury_rfds', 'injuries.id', '=', 'injury_rfds.injury_id'
        )->leftJoin(
            'current_situations', 'current_situations.id', '=', 'injury_rfds.current_situation_id'
        )->leftJoin(
            'current_situation_translations', function($join) use ($locale) {
                $join->on(
                    'current_situation_translations.current_situation_id', '=', 'current_situations.id'
                );
                $join->on(
                    'current_situation_translations.locale', '=', DB::raw("'$locale'")
                );
        })->where(
            'players.team_id', $team->id
        )->where(
            'injuries.entity_type', Player::class
        );

        return $query->get();
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
            'image',
            'cover',
            'club'=> function ($query) {
                $query->select('clubs.id','clubs.name');
            },
            'sport'=> function ($query) use ($locale) {
                $query->select('sports.id','sports.time_game')->withTranslation($locale);
            },
            'season',
            'type'=> function ($query) use ($locale) {
                $query->select('team_type.id')->withTranslation($locale);
            },
            'modality'=> function ($query) use ($locale) {
                $query->select('team_modality.id')->withTranslation($locale);
            },
        ];
    }
}
