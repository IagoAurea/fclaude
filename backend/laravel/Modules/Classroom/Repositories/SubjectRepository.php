<?php

namespace Modules\Classroom\Repositories;

use Modules\Classroom\Repositories\Interfaces\SubjectRepositoryInterface;
use Modules\Classroom\Entities\Subject;
use App\Services\ModelRepository;

class SubjectRepository extends ModelRepository implements SubjectRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'classroom_subjects';

    /**
     * @var string
     */
    protected $tableTranslations = 'classroom_subject_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'subject_id';

    /**
     * Model
     * @var Subject $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param Subject $model
     */
    public function __construct(Subject $model)
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
}
