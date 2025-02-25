<?php

namespace Modules\Qualification\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Classroom\Entities\ClassroomAcademicYear;
use Modules\User\Entities\User;

class Qualification extends Model
{
    use HasFactory;

    /**
     * Name of the table
     *
     * @var String
     */
    protected $table = 'qualifications';

    /**
     * List of relationships to be included on queries
     *
     * @var Array
     */
    protected $with = [
        'qualificationItems',
        'classroomAcademicYear'
    ];

    /**
     * List of all fillable properties
     *
     * @var Array
     */
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'classroom_academic_year_id',
        'classroom_academic_period_id'
    ];

    /**
     * The indicators that belong to the rubric.
     *
     * @return BelongsToMany
     */
    public function qualificationItems()
    {
        return $this->hasMany(QualificationItem::class);
    }

    /**
     * The classroom academic year.
     *
     * @return BelongsToMany
     */
    public function classroomAcademicYear()
    {
        return $this->belongsTo(ClassroomAcademicYear::class);
    }

    /**
     * The user create qualification.
     *
     * @return BelongsTo
     */
    public function tutor()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'full_name');
    }

    
}
