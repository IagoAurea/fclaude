<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\StudyLevelRepositoryInterface;
use Modules\Generality\Entities\StudyLevel;
use App\Services\ModelRepository;

class StudyLevelRepository extends ModelRepository implements StudyLevelRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    /** 
     * @var string
    */
    protected $table = 'study_levels';

    /** 
     * @var string
    */
    protected $tableTranslations = 'study_level_translations';
    
    /** 
     * @var string
    */
    protected $fieldAssociate = 'study_level_id';

    public function __construct(StudyLevel $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}