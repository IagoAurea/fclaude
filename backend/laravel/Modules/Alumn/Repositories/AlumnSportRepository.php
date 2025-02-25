<?php

namespace Modules\Alumn\Repositories;

use App\Services\ModelRepository;
use Modules\Alumn\Entities\AlumnSport;
use Modules\Alumn\Repositories\Interfaces\AlumnSportRepositoryInterface;

class AlumnSportRepository extends ModelRepository implements AlumnSportRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(AlumnSport $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
