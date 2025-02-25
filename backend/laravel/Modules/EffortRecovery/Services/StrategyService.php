<?php

namespace Modules\EffortRecovery\Services;

use App\Traits\ResponseTrait;

// Repositories
use Modules\EffortRecovery\Repositories\Interfaces\EffortRecoveryStrategyRepositoryInterface;

class StrategyService
{
    use ResponseTrait;

    /**
     * @var object $strategyRepositoryInterface
     */
    protected $strategyRepositoryInterface;

    /**
     * Create a new service instance
     */
    public function __construct(
        EffortRecoveryStrategyRepositoryInterface $strategyRepositoryInterface
    ) {
        $this->strategyRepositoryInterface = $strategyRepositoryInterface;
    }

    /**
     * Returns the list of all strategy items
     * 
     * @return array
     */
    public function list()
    {
        return $this->strategyRepositoryInterface->findAllTranslated();
    }
}
