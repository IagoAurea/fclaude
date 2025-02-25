<?php

namespace Modules\Club\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// External models
use Modules\Generality\Entities\Resource;
use Modules\User\Entities\User;
use Modules\Activity\Entities\Activity;
use Modules\Activity\Entities\EntityActivity;
use Modules\Address\Entities\Address;
use Modules\Classroom\Entities\Classroom;
use Modules\Classroom\Entities\Teacher;
use Modules\Team\Entities\Team;
use Modules\Club\Entities\AcademicYear;
use Modules\Staff\Entities\StaffUser;

class Club extends Model
{
    use SoftDeletes;

    const CLUB_USER_TYPE = 1;
    const ACADEMIC_USER_TYPE = 2;

    /**
     * Table related to the entity model
     * 
     * @var string
     */
    protected $table = 'clubs';

    /**
     * The calculated appended attributes that shall be shown
     *
     * @var array
     */
    protected $appends = [
        'users_count'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'image_id',
        'user_id', //TODO: añadir observer para añadir staff
        'club_type_id',
        'email',
        'webpage',
        'school_center_type_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'image_id'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone' => 'array',
        'mobile_phone' => 'array',
    ];

    /**
     * Function boot model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    // -- Calculated appended attributes
    /**
     * Return the count of related users table plus the current owner
     *
     * @return Int
     */
    public function getUsersCountAttribute()
    {
        return $this->users->count() + 1;
    }

    // -- Relationships

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
     * Returns a list of user objects related to the club
     *
     * @return Array
     */
    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'club_users'
        )->select(
            'users.id',
            'users.full_name',
            'users.email'
        );
    }

    /**
     * Returns the user owner of the club
     */
    public function owner()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        )->select(
            'id',
            'full_name',
            'email',
            'username'
        );
    }

    /**
     * Return a list of related activities
     *
     * @return Array
     */
    public function activities()
    {
        return $this->morphMany(
            Activity::class,
            'entity'
        )->with(
            'activity_type',
            'user',
            'entity',
            'secondaryEntity'
        )->orderBy(
            'date',
            'desc'
        );
    }

    /**
     * Return a list of all entity global related activities
     *
     * @return Array
     */
    public function entityActivities()
    {
        return $this->morphMany(
            EntityActivity::class,
            'entity'
        )->with(
            'activity'
        );
    }

    /**
     * Returns related address to the entity
     * 
     * @return Object
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'entity')->with('country', 'province');
    }

    /**
     * Return all the teams the club owns
     * 
     * @return array
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Relation with the classrooms
     * 
     * @return BelongsTo
     */
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    /**
     * Return all academic years related to academy type
     * 
     * @return array
     */
    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class)->with('academicPeriods');
    }

    /**
     * Return all teachers related to the club
     * 
     * @return array
     */
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    /**
     * Return all staffs related to the entity
     * 
     * @return array
     */
    public function staffs()
    {
        return $this->morphMany(
            StaffUser::class,
            'entity'
        )->with([
            'user', 'image', 'studyLevel', 'jobArea', 'positionStaff',
        ]);
    }
}
