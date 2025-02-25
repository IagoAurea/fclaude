<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjuryType;
use Modules\Injury\Repositories\Interfaces\InjuryTypeRepositoryInterface;

class InjuryTypeRepository extends ModelRepository implements InjuryTypeRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'injury_types';

    /**
     * @var string
    */
    protected $tableTranslations = 'injury_type_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'injury_type_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(InjuryType $model)
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