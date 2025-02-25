<?php

namespace Modules\Calculator\Repositories;

use App\Services\ModelRepository;
use Modules\Calculator\Entities\CalculatorEntityItemPointValue;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityItemPointValueRepositoryInterface;

class CalculatorEntityItemPointValueRepository extends ModelRepository
    implements CalculatorEntityItemPointValueRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(CalculatorEntityItemPointValue $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
