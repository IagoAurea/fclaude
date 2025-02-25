<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Entities\Referee;
use Modules\Generality\Repositories\Interfaces\RefereeRepositoryInterface;
use App\Services\ModelRepository;

class RefereeRepository extends ModelRepository implements RefereeRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(Referee $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Get referees by sport
     * @param $sport_code
     * @return array
     */
    public function findAllBySport($sport_code)
    {
        return $this->model->whereHas("sport", function($q) use ($sport_code) {
           $q->where("code", $sport_code);
        })->get();
    }


}
