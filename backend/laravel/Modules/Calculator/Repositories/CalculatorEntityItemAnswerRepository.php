<?php

namespace Modules\Calculator\Repositories;

use App\Services\ModelRepository;
use Modules\Calculator\Entities\CalculatorEntityItemAnswer;
use Modules\Calculator\Repositories\Interfaces\CalculatorEntityItemAnswerRepositoryInterface;

class CalculatorEntityItemAnswerRepository extends ModelRepository
    implements CalculatorEntityItemAnswerRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(CalculatorEntityItemAnswer $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
