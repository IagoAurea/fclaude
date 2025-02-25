<?php

namespace Modules\Test\Repositories;

use Modules\Test\Entities\Formula;
use App\Services\ModelRepository;
use Modules\Test\Repositories\Interfaces\FormulaRepositoryInterface;

class FormulaRepository extends ModelRepository implements FormulaRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'formulas';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        Formula $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }



    
}