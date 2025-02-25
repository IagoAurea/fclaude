<?php

namespace Modules\Competition\Repositories;

use App\Services\ModelRepository;
use Modules\Competition\Entities\TestCategoryMatch;
use Modules\Competition\Repositories\Interfaces\TestCategoryMatchRepositoryInterface;

class TestCategoryMatchRepository extends ModelRepository implements TestCategoryMatchRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(TestCategoryMatch $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

     /**
     * Find by code test category with type 
     * @param $test_code
     * @return array
     */
    public function findByCode($test_code)
    {
        return $this->model
            ->with('testTypeCategory')
            ->where(['code' => $test_code])
            ->first();
    }
}
