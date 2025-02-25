<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjuryIntrinsicFactor;
use Modules\Injury\Repositories\Interfaces\InjuryIntrinsicFactorRepositoryInterface;

class InjuryIntrinsicFactorRepository extends ModelRepository implements InjuryIntrinsicFactorRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'injury_intrinsic_factors';

    /**
     * @var string
    */
    protected $tableTranslations = 'injury_intrinsic_factor_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'injury_intrinsic_factor_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(InjuryIntrinsicFactor $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return diseases translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}