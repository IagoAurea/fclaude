<?php

namespace Modules\Classroom\Repositories;

use Modules\Classroom\Repositories\Interfaces\TeacherAreaRepositoryInterface;
use Modules\Classroom\Entities\TeacherArea;
use App\Services\ModelRepository;

class TeacherAreaRepository extends ModelRepository implements TeacherAreaRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'teacher_areas';

    /**
     * @var string
     */
    protected $tableTranslations = 'teacher_areas_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'teacher_area_id';

    /**
     * Model
     * @var TeacherArea $model
     */
    protected $model;

    /**
     * Instances a new repository class
     *
     * @param TeacherArea $model
     */
    public function __construct(TeacherArea $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}
