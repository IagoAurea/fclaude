<?php

namespace Modules\Classroom\Entities;

use Modules\User\Entities\User;
use Modules\Address\Entities\Address;
use Illuminate\Database\Eloquent\Model;
use Modules\Club\Entities\PositionStaff;
use Modules\Generality\Entities\JobArea;
use Modules\Generality\Entities\Resource;
use Modules\Tutorship\Entities\Tutorship;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *      title="Teacher",
 *      description="The teacher of a school center",
 *      @OA\Xml( name="Teacher"),
 *      @OA\Property(title="Name", property="name", description="String representing the name", format="string", example="Math"),
 *      @OA\Property(title="Email", property="email", description="String representing the email", format="string", example="teacher@example.com"),
 *      @OA\Property(
 *          title="School Center",
 *          property="club_id",
 *          description="Identifier of the school center it belongs to",
 *          format="string",
 *          example="11"
 *      ),
 *      @OA\Property(
 *          title="Teacher Area",
 *          property="teacher_area_id",
 *          description="Identifier of the area",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Gender",
 *          property="gender",
 *          description="String representing the gender",
 *          format="string",
 *          example="M"
 *      ),
 *       @OA\Property(
 *          title="Alias",
 *          property="alias",
 *          description="String representing the alias",
 *          format="string",
 *          example="Jhon"
 *       ),
 *       @OA\Property(
 *          title="Date of Birth",
 *          property="date_of_birth",
 *          description="String representing the date of birth",
 *          format="string",
 *          example="M"
 *       ),
 *       @OA\Property(
 *          title="Citizenship",
 *          property="citizenship",
 *          description="String representing the citizenship",
 *          format="string",
 *          example="Spain"
 *       ),
 *       @OA\Property(
 *          title="Image",
 *          property="image",
 *          description="File containing the image"
 *      ),
 * )
 */
class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'club_id',
        'teacher_area_id',
        'name',
        'email',
        'gender_id',
        'username',
        'birth_date',
        'citizenship',
        'position_staff_id',
        'responsibility',
        'department_chief',
        'class_tutor',
        'total_courses',
        'study_level_id',
        'image_id',
        'cover_id',
        'additional_information'
    ];

    protected $table = 'classroom_teachers';

    /**
     * Allways show this relationships
     *
     * @var array
     */
    protected $with = [
        'image',
        'address',
        'area',
        'position_staff'
    ];

    protected $appends = [
        'gender'
    ];

    /**
     * Get the team that owns the image.
     */
    public function cover()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the gender value attribute
     */
    public function getGenderAttribute()
    {
        $genders = User::getGenderTypes();
        $key = array_search($this->gender_id, array_column($genders, 'id'));

        return $genders[$key];
    }

    /**
     * Relationship with address
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'entity');
    }

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
     * Factory
     */
    protected static function newFactory()
    {
        return \Modules\Classroom\Database\factories\TeacherFactory::new();
    }

    /**
     * Get related tutorships
     *
     * @return Array
     */
    public function tutorships()
    {
        return $this->hasMany(Tutorship::class);
    }

    /**
     * Get related tutorships
     *
     * @return Array
     */
    public function work_experiences()
    {
        return $this->hasMany(WorkingExperiences::class);
    }

    /**
     * Get the team that owns the image.
     */
    public function position_staff()
    {
        return $this->belongsTo(PositionStaff::class);
    }

    /**
     * Return area objects related to the staff
     *
     * @return Object
     */
    public function area()
    {
        return $this->belongsTo(TeacherArea::class, 'teacher_area_id');
    }
}
