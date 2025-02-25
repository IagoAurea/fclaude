<?php

namespace Modules\EffortRecovery\Repositories;

use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerRepositoryInterface;
use Modules\EffortRecovery\Entities\WellnessQuestionnaireAnswer;
use App\Services\ModelRepository;

class WellnessQuestionnaireAnswerRepository extends ModelRepository implements WellnessQuestionnaireAnswerRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(WellnessQuestionnaireAnswer $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
