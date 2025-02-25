<?php


namespace Modules\Staff\Entities;

use \Illuminate\Database\Eloquent\Model;

// Models
use Modules\User\Entities\User;
use Modules\Address\Entities\Address;
use Modules\Club\Entities\PositionStaff;
use Modules\Generality\Entities\JobArea;
use Modules\Generality\Entities\Resource;
use Modules\Generality\Entities\StudyLevel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Staff\Entities\StaffWorkExperience;

class StaffUser extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'staff_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'email',
        'username',
        'birth_date',
        'is_active',
        'gender_id',
        'user_id',
        'entity_id',
        'entity_type',
        'study_level_id',
        'jobs_area_id',
        'image_id',
        'position_staff_id',
        'responsibility',
        'additional_information',
    ];

    /**
     * The attributes that must not be shown from querying.
     * 
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Auto calculated values
     * 
     * @var array
     */
    public $appends = [
        'gender',
    ];

    // ---------- Calculated Attributes ----------
    /**
     * Calculates gender object attribute
     * 
     * @return object
     */
    public function getGenderAttribute()
    {
        $genders = User::getGenderTypes();
        
        $key = array_search($this->gender_id ?? 0, array_column($genders, 'id'));

        return $genders[$key];
    }

    // ---------- Relationships ----------
    /**
     * Retrieves the related user object
     * 
     * @var object
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'email')->with('image');
    }

    /**
     * Get all of the models that own activities.
     * 
     * @return object
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Get the staff that owns the image.
     * 
     * @return object
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the related position staff item
     * 
     * @return object
     */
    public function positionStaff()
    {
        return $this->belongsTo(PositionStaff::class);
    }

    /**
     * Return area objects related to the staff
     * 
     * @return Object
     */
    public function jobArea() 
    {
        return $this->belongsTo(JobArea::class, 'jobs_area_id');
    }

    /**
     * Get the related addess to the entity
     * 
     * @return object
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'entity')->with('country', 'province');
    }

    /**
     * Get the study level related to the staff
     * 
     * @return object
     */
    public function studyLevel()
    {
        return $this->belongsTo(StudyLevel::class);
    }

    /**
     * Get all the related working experiences if registered
     */
    public function workExperiences()
    {
        return $this->hasMany(StaffWorkExperience::class);
    }
}
