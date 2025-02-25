<?php

namespace Modules\Classroom\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="ClassroomSubject",
 *      description="The relationship between a subject and a teacher in a school center",
 *      @OA\Xml( name="Classroom"),
 *      @OA\Property(
 *          title="Teacher",
 *          property="teacher_id",
 *          description="Identifier representing the teacher",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Subject",
 *          property="subject_id",
 *          description="Identifier representing the subject",
 *          format="string",
 *          example="1"
 *      )
 * )
 */
class ClassroomSubject extends Model
{
    /**
     * Table name
     */
    protected $table = 'classroom_teacher_subjects';

    /**
     * Fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'subject_id',
        'classroom_id',
        'is_class_tutor'
    ];

    /**
     * Always query the relationship
     *
     * @var array
     */
    protected $with = [
        'teacher',
        'subject'
    ];

    /**
     * Columns that must not be shown on data retrieval
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation with the teacher
     *
     * @return BelongsTo
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * Relation with the teacher
     *
     * @return BelongsTo
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relation with the subject
     *
     * @return BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
