<?php

namespace Modules\Activity\Repositories;

use App\Services\ModelRepository;
use Modules\Activity\Entities\Activity;
use Modules\Activity\Repositories\Interfaces\ActivityRepositoryInterface;

class ActivityRepository extends ModelRepository implements ActivityRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(Activity $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retrieves all activity relationships depending on type and id sent
     *
     * @param string $type
     * @param int $id
     * @return array
     */
    public function findHistory($type, $id)
    {
        // TODO: Must specify all items to be retrieved depending on the type received.
        return $this->model
            ->where('entity_type', $type)
            ->where('entity_id', $id)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Retrieves all activities related to the user id
     *
     * @param int $user_id
     * @return array
     */
    public function findAllByUser($user_id, $skip, $limit)
    {
        
        $relations = $this->getModelRelations();

        $query = $this->model->where('user_id', $user_id )
                    ->orderBy('date', 'desc')
                    ->with($relations);

        return $this->paginateResults($query, $skip, $limit);
    }


    /**
     * Retrieves all activities related to the team id
     *
     * @param int $team_id
     * @return array
     */
    public function findAllByTeam($team_id, $skip, $limit)
    {
        $relations = $this->getModelRelations();

        $query = $this->model
                    ->orderBy('date', 'desc')
                    ->with($relations)
                    ->where('team_id', $team_id);

        return $this->paginateResults($query, $skip, $limit);
    }
    
    /**
     * Retrieves all activities related to the clubs
     *
     * @param array $clubs
     * @return array
     */
    public function findAllByUserClubs($clubs, $skip, $limit)
    {
        $relations = $this->getModelRelations();

        $query = $this->model
                    ->orderBy('date', 'desc')
                    ->with($relations)
                    ->whereHas('team', function ($query) use ($clubs) {
                            $query->whereIn('club_id', $clubs);
                    });

        return $this->paginateResults($query, $skip, $limit);
    }

    /**
     * Retrieve all activities from all clubs
     */
    public function findClubActivities($clubIds, $type)
    {
        $query = $this->model->whereIn('entity_id', $clubIds)
            ->where('entity_type', 'Modules\Club\Entities\Club')
            ->with('activity_type', 'user')
            ->orderBy('date', 'desc');

        if (!is_null($type)) {
            $query = $query->where('type', $type);
        }

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
            'activity_type' => function ($query) use ($locale) {
                $query->select('activity_type.id')
                ->withTranslation($locale);
            },
            'entity'=> function ($query)  {
                $query->select('id');
            },
            'user' => function ($query) {
                $query->select('users.full_name','users.id');
            },
        ];
    }

    /**
     * Private function to paginate results to query
     * the same code on every query sent
     *
     * @return Array
     */
    private function paginateResults($query, $skip, $limit)
    {
        if ($skip == null) {
            $skip = 0;
        }

        $activities = $query->offset($skip)
            ->limit($limit)
            ->get();

        $total = $query->count();

        if ($limit > $total || $limit == null) {
            $limit = $total;
        }

        $data_activity['pagination']['skip']  =  intval($skip);
        $data_activity['pagination']['limit'] =  intval($limit);
        $data_activity['pagination']['total'] = $total;
        $data_activity['activities'] =   $activities;
    
        return $data_activity;
    }
}
