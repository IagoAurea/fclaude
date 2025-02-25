<?php

namespace Modules\Team\Repositories;

use App\Services\ModelRepository;
use Modules\Team\Entities\TypeLineup;
use Modules\Team\Repositories\Interfaces\TypeLineupRepositoryInterface;

class TypeLineupRepository extends ModelRepository implements TypeLineupRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(TypeLineup $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Get type lineups by sport and modality
     *
     * @param $sport_code "Sport's code"
     * @param $modality_code "Modality's code"
     * @return mixed
     */
    public function findAllBySportAndModality($sport_code, $modality_code)
    {
        $query = $this->model->whereHas('sport', function ($q) use ($sport_code) {
           $q->where("code", $sport_code);
        });

        if ($modality_code !== null) {
            $query = $query->whereHas("modality", function ($q) use ($modality_code) {
                $q->where("code", $modality_code);
            });
        }

        return $query->get();
    }
}
