<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\ReinstatementCriteria;
use Modules\Injury\Repositories\Interfaces\ReinstatementCriteriaRepositoryInterface;

class ReinstatementCriteriaRepository  extends ModelRepository implements ReinstatementCriteriaRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'reinstatement_criterias';

    /**
     * @var string
    */
    protected $tableTranslations = 'reinstatement_criteria_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'reinstatement_criteria_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        ReinstatementCriteria $model
    )
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