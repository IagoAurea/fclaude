<?php

namespace Modules\Health\Repositories;

use App\Services\ModelRepository;
use Modules\Health\Entities\AlcoholConsumption;
use Modules\Health\Repositories\Interfaces\AlcoholConsumptionRepositoryInterface;

class AlcoholConsumptionRepository extends ModelRepository implements AlcoholConsumptionRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'alcohol_consumption';

    /**
     * @var string
    */
    protected $tableTranslations = 'alcohol_consumption_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'alcohol_consumption_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(AlcoholConsumption $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return alcohol comsumption translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }


}