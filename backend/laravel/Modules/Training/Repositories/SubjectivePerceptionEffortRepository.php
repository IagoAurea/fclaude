<?php

namespace Modules\Training\Repositories;

use App\Services\ModelRepository;
use Modules\Training\Entities\SubjecPerceptEffort;
use Modules\Training\Repositories\Interfaces\SubjectivePerceptionEffortRepositoryInterface;

class SubjectivePerceptionEffortRepository extends ModelRepository implements SubjectivePerceptionEffortRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'subjec_percept_efforts';

    /**
     * @var string
    */
    protected $tableTranslations = 'subjec_percept_effort_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'subjec_percept_effort_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(SubjecPerceptEffort $model)
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