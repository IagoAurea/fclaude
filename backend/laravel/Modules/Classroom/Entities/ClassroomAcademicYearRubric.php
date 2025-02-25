<?php

namespace Modules\Classroom\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Evaluation\Entities\Rubric;
use Modules\Classroom\Entities\ClassroomAcademicYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Classroom\Database\Factories\ClassroomAcademicYearRubricFactory;

// This entity represents an evaluation appointment for a given rubric and classroom
class ClassroomAcademicYearRubric extends Model
{
    use HasFactory;

    const STATUS_NOT_EVALUATED = 'NOT_EVALUATED';
    const STATUS_EVALUATED = 'EVALUATED';

    protected $table = 'classroom_rubric';

    /**
     * The fields that can be mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'classroom_academic_year_id',
        'rubric_id',
        'evaluation_date',
        'status',
        'created_at',
        'updated_at'
    ];

    /**
     * The fields that
     * 
     * @var array
     */
    protected $with = [
        'classroomsAcademicYear',
        'rubric'
    ];

    /**
     * The classrooms that belong to the rubric.
     *
     * @return BelongsToMany
     */
    public function classroomsAcademicYear()
    {
        return $this->belongsTo(ClassroomAcademicYear::class, 'classroom_academic_year_id');
    }

    /**
     * The classrooms that belong to the rubric.
     *
     * @return BelongsToMany
     */
    public function rubric()
    {
        return $this->belongsTo(Rubric::class, 'rubric_id');
    }

    public static function newFactory()
    {
        return ClassroomAcademicYearRubricFactory::new();
    }
}
