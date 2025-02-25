<?php

namespace Modules\Team\Entities;

use Illuminate\Support\Str;
use Modules\Club\Entities\Club;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\TeamType;
use Modules\Player\Entities\Player;
use Illuminate\Foundation\Auth\User;
use Modules\Staff\Entities\StaffUser;
use Modules\Activity\Entities\Activity;
use Modules\Team\Entities\TeamModality;
use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Season;
use Modules\Exercise\Entities\Exercise;
use Modules\Training\Entities\WorkGroup;
use Modules\Generality\Entities\Resource;
use Modules\Activity\Entities\EntityActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Competition\Entities\Competition;
use Modules\Training\Entities\ExerciseSession;
use Modules\Team\Database\Factories\TeamFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *  schema="TeamSchema",
 *  type="object",
 *  description="Team Type Schema",
 *  @OA\Property(property="id", type="int64", example="1"),
 *  @OA\Property(property="code", type="string", example="string"),
 *  @OA\Property(property="name", type="string", example="string"),
 *  @OA\Property(property="slug", type="string", example="string"),
 *  @OA\Property(property="color", type="string", example="string"),
 *  @OA\Property(property="category", type="string", example="string"),
 *  @OA\Property(property="type_id", type="int64", example="1"),
 *  @OA\Property(property="modality_id", type="int64", example="1"),
 *  @OA\Property(property="season_id", type="int64", example="1"),
 *  @OA\Property(property="gender_id", type="int64", example="1"),
 *  @OA\Property(property="image_id", type="int64", example="1"),
 *  @OA\Property(property="cover_id", type="int64", example="1"),
 *  @OA\Property(property="sport_id", type="int64", example="1"),
 *  @OA\Property(property="club_id", type="int64", example="1"),
 *  @OA\Property(property="created_at", type="date-time", example="2022-01-01 00:00:00"),
 *  @OA\Property(property="updated_at", type="date-time", example="2022-01-01 00:00:00"),
 *  @OA\Property(property="image_url", type="string", example="string"),
 *  @OA\Property(property="cover_url", type="string", example="string"),
 * )
 */
class Team extends Model
{
    use HasFactory, SoftDeletes;

    const GENDER_MIXED = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'color',
        'category',
        'type_id',
        'modality_id',
        'season_id',
        'gender_id',
        'image_id',
        'cover_id',
        'club_id',
        'sport_id',
        'user_id',
    ];

    /**
     * Attributes that must not be shown from querying
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];

    protected $with = [
        'season',
        'sport',
        'type',
        'image',
        'cover'
    ];

    /**
     * Additional fields
     * @var array
     */
    protected $appends = [
        'staff_count',
    ];

    /**
     * Register any events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = Str::uuid()->toString();
        });

        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    /**
     * Get gender types
     * @return array
     */
    public static function getGenderTypes()
    {
        return [
            [
                'id' => self::GENDER_MIXED,
                'code' => 'mixed',
            ],
            [
                'id' => self::GENDER_MALE,
                'code' => 'male',
            ],
            [
                'id' => self::GENDER_FEMALE,
                'code' => 'female',
            ],
        ];
    }


    /**
     * Get the related staff count
     */
    public function getStaffCountAttribute()
    {
        // return $this->teamStaffs()->count();
        return null;
    }

    // ----------------- Relationships -----------------------
    /**
     * Get the team user owner
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the team that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class)->select(
            'id',
            'url',
            'mime_type',
            'size'
        );
    }

    /**
     * Get the team that owns the image.
     */
    public function cover()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the team that owns the club.
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Get the team that owns the season.
     */
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    /**
     * Get the team that owns the type.
     */
    public function type()
    {
        return $this->belongsTo(TeamType::class);
    }

    /**
     * Get the team that owns the type.
     */
    public function modality()
    {
        return $this->belongsTo(TeamModality::class)->withTranslation(
            app()->getLocale()
        );
    }

    /**
     * Get the sport that owns the type.
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Get the players that play at the Team.
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TeamFactory::new();
    }

    /**
     * Returns a list of Work Groups objects related to the Team
     *
     * @return Array
     */
    public function workGroups()
    {
        return $this->HasMany(WorkGroup::class);
    }

    /**
     * Returns a list of Exercise Session objects related to the Team
     *
     * @return Array
     */
    public function exerciseSessions()
    {
        return $this->HasMany(ExerciseSession::class);
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

    /**
     * Return a list of all entity global related activities
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
     * Retrieves a list of activities related to the team
     * 
     * @return array
     */
    public function activities()
    {
        return $this->morphMany(
            Activity::class,
            'secondary_entity'
        )->with(
            'activity_type',
            'user'
        )->orderBy(
            'date',
            'desc'
        );
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

    /**
     * Retrieves a list of all related matches of team
     * 
     * @return array
     */
    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }
}
