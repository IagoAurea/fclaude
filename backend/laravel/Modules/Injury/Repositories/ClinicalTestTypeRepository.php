<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\ClinicalTestType;
use Modules\Injury\Repositories\Interfaces\ClinicalTestTypeRepositoryInterface;

class ClinicalTestTypeRepository extends ModelRepository implements ClinicalTestTypeRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'clinical_test_types';

    /**
     * @var string
    */
    protected $tableTranslations = 'clinical_test_type_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'clinical_test_type_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(ClinicalTestType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return translations
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * Get randomized ids
     */
    public function getRegisteredIds()
    {
        return $this->model->pluck('id')->toArray();
    }
}