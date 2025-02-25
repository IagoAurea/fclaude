<?php

namespace Modules\Competition\Repositories;

use App\Services\ModelRepository;
use Modules\Competition\Entities\TypeCompetitionSport;
use Modules\Competition\Repositories\Interfaces\TypeCompetitionSportRepositoryInterface;

class TypeCompetitionSportRepository extends ModelRepository implements TypeCompetitionSportRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(TypeCompetitionSport $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}
