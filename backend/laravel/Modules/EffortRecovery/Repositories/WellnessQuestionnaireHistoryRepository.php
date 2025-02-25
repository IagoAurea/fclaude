<?php

namespace Modules\EffortRecovery\Repositories;

use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireHistoryRepositoryInterface;
use Modules\EffortRecovery\Entities\WellnessQuestionnaireHistory;
use App\Services\ModelRepository;

class WellnessQuestionnaireHistoryRepository extends ModelRepository implements WellnessQuestionnaireHistoryRepositoryInterface
{
    /**
     * Create a new repository instance
     */
    public function __construct(WellnessQuestionnaireHistory $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
