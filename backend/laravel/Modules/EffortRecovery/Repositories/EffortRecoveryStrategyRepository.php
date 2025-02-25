<?php

namespace Modules\EffortRecovery\Repositories;

use Modules\EffortRecovery\Repositories\Interfaces\EffortRecoveryStrategyRepositoryInterface;
use Modules\EffortRecovery\Entities\EffortRecoveryStrategy;
use App\Services\ModelRepository;

class EffortRecoveryStrategyRepository extends ModelRepository implements EffortRecoveryStrategyRepositoryInterface
{
     /**
     * @var object
    */
    protected $model;
    
    /**
     * @var string
     */
    protected $table = 'effort_recovery_strategies';

    /**
     * @var string
     */
    protected $tableTranslations = 'effort_recovery_strategy_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'effort_recovery_strategy_id';

    /**
     * Create a new repository instance
     */
    public function __construct(EffortRecoveryStrategy $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return all effort recovery strategies with translations
     *
     * @return array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}
