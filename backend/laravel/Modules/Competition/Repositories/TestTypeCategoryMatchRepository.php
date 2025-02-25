<?php

namespace Modules\Competition\Repositories;

use App\Services\ModelRepository;
use Modules\Competition\Entities\TestTypeCategoryMatch;
use Modules\Competition\Repositories\Interfaces\TestTypeCategoryMatchRepositoryInterface;

class TestTypeCategoryMatchRepository extends ModelRepository implements TestTypeCategoryMatchRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(TestTypeCategoryMatch $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}
