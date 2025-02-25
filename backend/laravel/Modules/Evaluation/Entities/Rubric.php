<?php

namespace Modules\Evaluation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Classroom\Entities\ClassroomAcademicYear;

class Rubric extends Model
{
    use SoftDeletes;

    protected $table = 'evaluation_rubrics';

    protected $fillable = [
        'name',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $with = [
        'indicators',
        'classrooms'
    ];

    /**
     * The classrooms that belong to the rubric.
     *
     * @return BelongsToMany
     */
    public function classrooms()
    {
        return $this->belongsToMany(ClassroomAcademicYear::class, 'classroom_rubric')
            ->withPivot('id')
            ->withTimestamps();
    }

    /**
     * The indicators that belong to the rubric.
     *
     * @return BelongsToMany
     */
    public function indicators()
    {
        return $this->belongsToMany(Indicator::class, 'indicator_rubric')
            ->withPivot('id');
    }

    protected static function newFactory()
    {
        return \Modules\Evaluation\Database\factories\RubricFactory::new();
    }
}
