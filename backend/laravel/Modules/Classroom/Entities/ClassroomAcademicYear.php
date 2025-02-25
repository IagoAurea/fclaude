<?php

namespace Modules\Classroom\Entities;

use Illuminate\Database\Eloquent\Model;

// Entities
use Modules\Alumn\Entities\Alumn;
use Modules\Club\Entities\AcademicYear;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassroomAcademicYear extends Model
{
    use HasFactory;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'classroom_academic_years';

    /**
     * Table name
     *
     * @var array
     */
    protected $with = [
        'academicYear',
        'classroom',
        'tutor',
        'physicalTeacher',
        'subject'
    ];

    /**
     * Timestmaps boolean set
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Set of fillable attributes on model
     *
     * @var array
     */
    protected $fillable = [
        'academic_year_id',
        'classroom_id',
        'physical_teacher_id',
        'tutor_id',
        'subject_id',
        'subject_text'
    ];

    /**
     * Relation with the physical teacher
     *
     * @return BelongsTo
     */
    public function physicalTeacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relation with the tutor
     *
     * @return BelongsTo
     */
    public function tutor()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relation with the classroom
     *
     * @return BelongsTo
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class)->with('scholarCenter');
    }

    /**
     * Relation with the subject
     *
     * @return BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Relation with the academic year
     *
     * @return BelongsTo
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class)->with('academicPeriods');
    }

    /**
     * Set of related alumns
     *
     * @return array
     */
    public function alumns()
    {
        return $this->belongsToMany(Alumn::class, 'classroom_academic_year_alumns')
            ->with('image');
    }

    /**
     * Factory
     */
    protected static function newFactory()
    {
        return \Modules\Classroom\Database\factories\ClassroomAcademicYearFactory::new();
    }
}
