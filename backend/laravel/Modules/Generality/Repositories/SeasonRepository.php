<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\SeasonRepositoryInterface;
use Modules\Generality\Entities\Season;
use App\Services\ModelRepository;

class SeasonRepository extends ModelRepository implements SeasonRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(Season $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}