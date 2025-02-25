<?php

namespace Modules\Nutrition\Repositories;

use App\Services\ModelRepository;
use Modules\Nutrition\Entities\AthleteActivity;
use Modules\Nutrition\Repositories\Interfaces\AthleteActivityRepositoryInterface;

class AthleteActivityRepository extends ModelRepository implements AthleteActivityRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'athlete_activities';

    /**
     * @var object
    */
    protected $model;

    public function __construct(AthleteActivity $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}