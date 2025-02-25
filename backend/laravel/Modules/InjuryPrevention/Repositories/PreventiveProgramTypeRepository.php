<?php

namespace Modules\InjuryPrevention\Repositories;

use App\Services\ModelRepository;
use Modules\InjuryPrevention\Entities\PreventiveProgramType;
use Modules\InjuryPrevention\Repositories\Interfaces\PreventiveProgramTypeRepositoryInterface;

class PreventiveProgramTypeRepository extends ModelRepository implements PreventiveProgramTypeRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'preventive_program_types';

    /**
     * @var string
    */
    protected $tableTranslations = 'preventive_program_type_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'preventive_program_type_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(PreventiveProgramType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return preventive_program_types translations
     *
     * @return array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}