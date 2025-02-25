<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjuryExtrinsicFactor;
use Modules\Injury\Repositories\Interfaces\InjuryExtrinsicFactorRepositoryInterface;

class InjuryExtrinsicFactorRepository extends ModelRepository implements InjuryExtrinsicFactorRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'injury_extrinsic_factors';

    /**
     * @var string
    */
    protected $tableTranslations = 'injury_extrinsic_factor_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'injury_extrinsic_factor_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(InjuryExtrinsicFactor $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return extrinsic factor translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}