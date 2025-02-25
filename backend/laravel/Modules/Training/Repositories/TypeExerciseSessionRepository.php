<?php

namespace Modules\Training\Repositories;

use App\Services\ModelRepository;
use Modules\Training\Entities\TypeExerciseSession;
use Modules\Training\Repositories\Interfaces\TypeExerciseSessionRepositoryInterface;

class TypeExerciseSessionRepository extends ModelRepository implements TypeExerciseSessionRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'type_exercise_sessions';

    /**
     * @var string
    */
    protected $tableTranslations = 'type_exercise_session_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'type_exercise_session_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(TypeExerciseSession $model)
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