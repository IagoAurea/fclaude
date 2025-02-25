<?php

namespace Modules\Evaluation\Repositories;

use Modules\Evaluation\Repositories\Interfaces\RubricRepositoryInterface;
use Modules\Evaluation\Exceptions\RubricDoesNotExistException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Evaluation\Entities\Rubric;
use App\Services\ModelRepository;
use Modules\Classroom\Entities\ClassroomAcademicYearRubric;

class RubricRepository extends ModelRepository implements RubricRepositoryInterface
{
    /**
     * Model
     * @var Rubric $model
     */
    protected $model;

    /**
     * ClassroomAcademicYearRubric Model
     * @var ClassroomAcademicYearRubric $classroomAcademicYearRubric
     */
    protected $classroomAcademicYearRubric;

    /**
     * Instances a new repository class
     * 
     * @param Rubric $model
     */
    public function __construct(Rubric $model, ClassroomAcademicYearRubric $classroomAcademicYearRubric)
    {
        $this->model = $model;
        $this->classroomAcademicYearRubric = $classroomAcademicYearRubric;

        parent::__construct($this->model);
    }

    /**
     * Find rubrics by classroom id
     * 
     * @param int $classroom_id
     */
    public function findByClassroom($classroom_id)
    {
        $rubric_ids = $this->classroomAcademicYearRubric
            ->where(['classroom_academic_year_id' => $classroom_id])
            ->with('rubric')
            ->get()
            ->pluck('rubric.id');

        if (!$rubric_ids) {
            throw new ModelNotFoundException;
        }

        return $this
            ->model
            ->whereIn('id', $rubric_ids)
            ->get();
    }

    /**
     * Find rubrics by alumn id
     * 
     * @param int $classroom_academic_year_id
     */
    public function rubricsByClassroom($classroom_id)
    {
        $rubric_ids = $this->classroomAcademicYearRubric
            ->where(['classroom_academic_year_id' => $classroom_id])
            ->with('rubric')
            ->get()
            ->pluck('rubric.id');

        if (!$rubric_ids) {
            throw new ModelNotFoundException;
        }

        return $this
            ->model
            ->whereIn('id', $rubric_ids)
            ->get();
    }

    /**
     * Assign indicators to the rubric
     * 
     * @param Boolean
     */
    public function assignIndicatorsToRubric($rubric_id, $indicators)
    {
        $rubric = $this->find($rubric_id);

        if (!$rubric) {
            throw new RubricDoesNotExistException;
        }

        return $rubric->indicators()->sync($indicators);
    }

    /**
     * Assign classrooms to the rubric and remove the existing ones;
     * 
     * @param Boolean
     */
    public function assignClassroomsToRubric($rubric_id, $classrooms)
    {
        $rubric = $this->find($rubric_id);

        if (!$rubric) {
            throw new RubricDoesNotExistException;
        }

        return $rubric->classrooms()->attach($classrooms);
    }

    /**
     * Attach a classrooms to the rubric
     * 
     * @param Boolean
     */
    public function attachClassroomsToRubric($rubric_id, $classrooms)
    {
        $rubric = $this->find($rubric_id);

        if (!$rubric) {
            throw new RubricDoesNotExistException;
        }

        foreach ($classrooms as $classroom) {
            $rubric->classrooms()->sync($classroom);
        }

        return $this->find($rubric_id)->classrooms;
    }

    /**
     * Detach a classrooms to the rubric
     * 
     * @param Boolean
     */
    public function detachClassroomsToRubric($rubric_id, $classrooms)
    {
        $rubric = $this->find($rubric_id);

        if (!$rubric) {
            throw new RubricDoesNotExistException;
        }

        foreach ($classrooms as $classroom) {
            $rubric->classrooms()->detach($classroom);
        }

        return $this->find($rubric_id)->classrooms;
    }

    /**
     * Get indicators with percentage associated to a given rubric
     * 
     * @param mixed
     */
    public function getIndicators($rubric_id)
    {
        $rubric = $this->find($rubric_id);

        if (!$rubric) {
            throw new RubricDoesNotExistException;
        }

        return $rubric->indicators->map(function ($indicator) {
            return $indicator->pivot->id;
        });
    }

    /**
     * Get the comoetences associated to a given rubric with their indicator
     * 
     * @param int $rubric_id
     */
    public function getCompetences($rubric_id)
    {
        $rubric = $this->find($rubric_id);

        if (!$rubric) {
            throw new RubricDoesNotExistException;
        }

        return $rubric->indicators->map(function ($indicator) {
            return [
                'indicator_id' => $indicator->pivot->id,
                'competences' => $indicator->competences->map->id->toArray()
            ];
        });
    }

    /**
     * Get rubric collection by a given id
     * 
     * @param int $rubric_id
     */
    public function getExportDataById($rubric_id)
    {
        $rubric = $this->find($rubric_id);

        if (!$rubric) {
            throw new RubricDoesNotExistException;
        }

        return $rubric;
    }
}
