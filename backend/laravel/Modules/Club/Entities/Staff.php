<?php

namespace Modules\Club\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// External models
use Modules\Generality\Entities\Resource;
use Modules\Generality\Entities\JobArea;
use Modules\User\Entities\User;
use Modules\Club\Entities\Club;
use Modules\Club\Entities\ClubUser;
use Modules\Club\Entities\PositionStaff;
use Modules\Club\Entities\WorkingExperiences;
use Modules\Generality\Entities\StudyLevel;

class Staff extends Model
{
    use SoftDeletes;

    protected $table = 'staffs';

    const GENDER_UNDEFINED = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'user_id',
        'position_staff_id',
        'jobs_area_id',
        'birth_date',
        'alias',
        'additional_information',
        'name',
        'gender',
        'city',
        'zipcode',
        'address',
        'mobile_phone',
        'image_id',
        'country_id',
        'province_id',
        'email',
        'study_level_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'mobile_phone' => 'array'
    ];

    /**
     * Get gender types
     * @return array
     */
    public static function getGenderTypes()
    {
        return [
            [
                "id" => self::GENDER_UNDEFINED,
                "code" => 'undefined',
            ],
            [
                "id" => self::GENDER_MALE,
                "code" => 'male',
            ],
            [
                "id" => self::GENDER_FEMALE,
                "code" => 'female',
            ],
        ];
    }

    /**
    * Return user objects related to the staff
    * 
    * @return Object
    */
    public function user () 
    {
        return $this->belongsTo(User::class)->select('id','email');
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
    public function area () 
    {
        return $this->belongsTo(JobArea::class,'jobs_area_id');
    }

    /**
    * Returns list working experiences objects related to the staff
    * 
    * @return Array
    */
    public function working_experiences () 
    {
        return $this->hasMany(WorkingExperiences::class, 'staff_id');
    }


    /**
     * Get the staff that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
    * Returns list clubs objects related to the user
    * 
    * @return Array
    */
    public function clubs () 
    {
        return $this->hasManyThrough(
            Club::class, // Target model 
            ClubUser::class, // Intermediate model
            'user_id', // Foreign key in intermediate table
            'id', // Foreign key in the target table
            'id', // Primary key in source table
            'club_id' // key in the intermediate table
        );
    }
    
    /**
    * Return study level object related to the working experiences
    * 
    * @return Object
    */
    public function study_level () 
    {
        return $this->belongsTo(StudyLevel::class,'study_level_id');
    }
}
