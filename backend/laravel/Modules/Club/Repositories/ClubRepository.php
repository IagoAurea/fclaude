<?php

namespace Modules\Club\Repositories;

use Illuminate\Http\Response;
use Modules\Club\Entities\Club;
use App\Services\ModelRepository;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\DB;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

class ClubRepository extends ModelRepository implements ClubRepositoryInterface
{
    use TranslationTrait;

    /**
     * @var object
     */
    protected $model;

    public function __construct(Club $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * @return array Returns an array of Clubs objects
     */
    public function findUserClubs($userId, $clubTypeId, $teamsId = [], $relations = [])
    {
        $query = $this->model->with('image')
            ->where(function ($query) use ($userId, $teamsId) {
                $query->whereIn('id', $teamsId)
                      ->orWhere('user_id', $userId);
            })
            ->where('club_type_id', $clubTypeId);
        
        if(count($relations) > 0) {
            $query->with($relations);
        }

        return $query->get();
    }

    /**
     * @return Object Returns an existing club depending on the parameters sent
     */
    public function getClubById($clubId)
    {
        $relations = $this->getModelRelations();

        $item = $this->model->with($relations)
            ->where('id', $clubId)
            ->first();

        if (!$item) {
            abort(response()->error($this->translator('club_not_found'), Response::HTTP_NOT_FOUND));
        }

        return $item;
    }

    /**
     * @return Object Basic information about the club, and all the list of activities
     */
    public function getClubActivities ($clubId)
    {
        // Retrieve the needed item
        $club = $this->model->where('id', $clubId)
            ->select('id', 'name')
            ->first();

        // In case the club does not exists
        if (!$club) {
            abort(response()->error($this->translator('club_not_found'), Response::HTTP_NOT_FOUND));
        }

        // Parse the activities related to the club
        foreach ($club->activities as $act) {
            $act->user;
            $act->activity_type;
        }

        // Return the club
        return $club;
    }

    /**
     * @return Array Returns an array of Package objects
     */
    public function getClubMembers($id)
    {
        // Return all the user related clubs
        return $this->model->with('users')
            ->find($id);
    }

    /**
     * Private function to retrieve needed model relations in order to not to repeat
     * the same code on every query sent
     *
     * @return Array
     */
    private function getModelRelations()
    {
        return [ 'image' ];
    }

    /**
    * @return array Returns an array of Package objects
    */
    public function getRandomClub()
    {
        // Return one random club
        return $this->model->get()->shuffle()->first();
    }


    /**
    * @return array
    * Returns an Clubs by owner
    */
    public function findByOwner($email)
    {
        $query = DB::table('clubs')
                ->join('users', 'clubs.user_id', '=', 'users.id')
                ->where('users.email', $email)
                ->select('clubs.*');

        return $query->get();
    }
}
