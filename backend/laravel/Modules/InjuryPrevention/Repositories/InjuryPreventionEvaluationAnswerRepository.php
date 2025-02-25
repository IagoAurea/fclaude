<?php

namespace Modules\InjuryPrevention\Repositories;

use Modules\InjuryPrevention\Repositories\Interfaces\InjuryPreventionEvaluationAnswerRepositoryInterface;
use Modules\InjuryPrevention\Entities\InjuryPreventionEvaluationAnswer;
use App\Services\ModelRepository;

class InjuryPreventionEvaluationAnswerRepository extends ModelRepository implements InjuryPreventionEvaluationAnswerRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(InjuryPreventionEvaluationAnswer $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
