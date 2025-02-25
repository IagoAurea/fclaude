<?php

namespace Modules\Health\Repositories;

use App\Services\ModelRepository;
use Modules\Health\Entities\TobaccoConsumption;
use Modules\Health\Repositories\Interfaces\TobaccoConsumptionRepositoryInterface;

class TobaccoConsumptionRepository extends ModelRepository implements TobaccoConsumptionRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'tobacco_consumption';

    /**
     * @var string
    */
    protected $tableTranslations = 'tobacco_consumption_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'tobacco_consumption_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(TobaccoConsumption $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return tobacco comsumption translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }


}