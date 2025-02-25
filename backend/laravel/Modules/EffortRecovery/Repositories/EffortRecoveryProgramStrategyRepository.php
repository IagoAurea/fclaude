<?php

namespace Modules\EffortRecovery\Repositories;

use Modules\EffortRecovery\Repositories\Interfaces\EffortRecoveryProgramStrategyRepositoryInterface;
use Modules\EffortRecovery\Entities\EffortRecoveryProgramStrategy;
use App\Services\ModelRepository;

class EffortRecoveryProgramStrategyRepository extends ModelRepository
    implements EffortRecoveryProgramStrategyRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;
    /**
     * Create a new repository instance
     */
    public function __construct(EffortRecoveryProgramStrategy $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
