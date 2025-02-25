<?php

namespace Modules\Nutrition\Repositories;

use App\Services\ModelRepository;
use Modules\Nutrition\Entities\WeightControl;
use Modules\Nutrition\Repositories\Interfaces\WeightControlRepositoryInterface;

class WeightControlRepository extends ModelRepository implements WeightControlRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'weight_controls';


    /**
     * @var object
    */
    protected $model;

    public function __construct(
        WeightControl $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Public function to retrieve the Weight Controls by id
     *
     * @return Collection
     */

    public function findAllWeightControlsById($id)
    {
        return $this->model
            ->select('weight','created_at as weight date')
            ->where('player_id',$id)
            ->get();
    }

}