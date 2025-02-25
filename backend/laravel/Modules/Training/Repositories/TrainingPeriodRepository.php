<?php

namespace Modules\Training\Repositories;

use App\Services\ModelRepository;
use Modules\Training\Entities\TrainingPeriod;
use Modules\Training\Repositories\Interfaces\TrainingPeriodRepositoryInterface;

class TrainingPeriodRepository extends ModelRepository implements TrainingPeriodRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'training_periods';

    /**
     * @var string
    */
    protected $tableTranslations = 'training_period_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'training_period_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(TrainingPeriod $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return diet translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

}