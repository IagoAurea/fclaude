<?php

namespace Modules\Exercise\Repositories;

use Modules\Exercise\Repositories\Interfaces\ExerciseEducationLevelRepositoryInterface;
use Modules\Exercise\Entities\ExerciseEducationLevel;
use App\Services\ModelRepository;

class ExerciseEducationLevelRepository extends ModelRepository implements ExerciseEducationLevelRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'exercise_education_levels';

    /**
     * @var string
     */
    protected $tableTranslations = 'exercise_education_level_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'exercise_education_level_id';

    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(ExerciseEducationLevel $model)
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
