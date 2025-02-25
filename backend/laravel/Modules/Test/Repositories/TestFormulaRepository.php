<?php

namespace Modules\Test\Repositories;

use Modules\Test\Entities\TestFormula;
use App\Services\ModelRepository;
use Modules\Test\Repositories\Interfaces\TestFormulaRepositoryInterface;

class TestFormulaRepository extends ModelRepository implements TestFormulaRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'test_formulas';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        TestFormula $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }



    
}