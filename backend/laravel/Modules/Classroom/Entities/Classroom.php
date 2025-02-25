<?php

namespace Modules\Classroom\Entities;

use Modules\Club\Entities\Club;
use Illuminate\Database\Eloquent\Model;
use Modules\Club\Entities\AcademicYear;
use Modules\Evaluation\Entities\Rubric;
use Modules\Exercise\Entities\Exercise;
use Modules\Generality\Entities\Resource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Classroom\Entities\ClassroomAcademicYear;

/**
 * @OA\Schema(
 *      title="Classroom",
 *      description="The classroom of a school center",
 *      @OA\Xml( name="Classroom"),
 *      @OA\Property(
 *          title="Name",
 *          property="name",
 *          description="String representing the name",
 *          format="string",
 *          example="string"
 *      ),
 *      @OA\Property(
 *          title="School Center",
 *          property="club_id",
 *          description="Identifier of the school center it belongs to",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Age",
 *          property="age_id",
 *          description="Identifier representing the age",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Physical Teacher",
 *          property="physical_teacher_id",
 *          description="Identifier representing the physical teacher",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Tutor",
 *          property="tutor_id",
 *          description="Identifier representing the tutor",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Color",
 *          property="color",
 *          description="String of 6 char representing the Hexadecimal code of the color",
 *          format="string",
 *          example="FFFFFF"
 *      ),
 *      @OA\Property(
 *          title="Image",
 *          property="image",
 *          description="File containing the image"
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
class Classroom extends Model
{
    use SoftDeletes;

    /**
     * Fillable properties
     *
     * @var array
     */
    protected $fillable = [
        'club_id',
        'name',
        'observations',
        'age_id',
        'color',
        'image_id',
        'cover_id'
    ];

    /**
     * Allways show this relationships
     *
     * @var array
     */
    protected $with = [
        'image',
        'cover'
    ];


    /**
     * Returns the related image resource object
     *
     * @return Object
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Returns the related image resource object
     *
     * @return Object
     */
    public function cover()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Relation with the subject
     *
     * @return BelongsTo
     */
    public function scholarCenter()
    {
        return $this->belongsTo(Club::class, 'club_id');
    }

    /**
     * The rubrics that belong to the indicator.
     *
     * @return BelongsToMany
     */
    public function rubrics()
    {
        return $this->belongsToMany(Rubric::class, 'classroom_rubric');
    }

    /**
     * Returns all the academic years the club is involved to
     *
     * @return array
     */
    public function academicYears()
    {
        return $this->belongsToMany(AcademicYear::class, 'classroom_academic_years')->withPivot('id');
    }

    /**
     * Returns all the academic years relationship tables involved
     *
     * @return array
     */
    public function academicYearRelations()
    {
        return $this->hasMany(ClassroomAcademicYear::class)->with('alumns');
    }

    /**
     * Return the first active academical year
     *
     * @return array
     */
    public function activeAcademicYears()
    {
        return $this->belongsToMany(AcademicYear::class, 'classroom_academic_years')
            ->where('is_active', true)
            ->withPivot('id')
            ->with('academicPeriods');
    }

    /**
     * Returns the related club item
     *
     * @return object
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Returns a list of related exercises
     *
     * @return array
     */
    public function exercises()
    {
        return $this->morphMany(Exercise::class, 'entity');
    }
}
