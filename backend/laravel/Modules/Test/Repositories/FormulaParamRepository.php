<?php

namespace Modules\Test\Repositories;

use Modules\Test\Entities\FormulaParam;
use App\Services\ModelRepository;
use Modules\Test\Repositories\Interfaces\FormulaParamRepositoryInterface;

class FormulaParamRepository extends ModelRepository implements FormulaParamRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'test_formula_params';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        FormulaParam $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }



    
}