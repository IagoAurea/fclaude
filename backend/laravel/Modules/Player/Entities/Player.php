<?php

namespace Modules\Player\Entities;

use Carbon\Carbon;
use Modules\Team\Entities\Team;
use Modules\User\Entities\User;
use Modules\Player\Entities\Skills;
use Modules\Family\Entities\Family;
use Modules\Injury\Entities\Injury;
use Modules\Health\Entities\Disease;
use Modules\Health\Entities\Allergy;
use Modules\Health\Entities\Surgery;
use Modules\Address\Entities\Address;
use Modules\Health\Entities\AreaBody;
use Illuminate\Database\Eloquent\Model;
use Modules\Fisiotherapy\Entities\File;
use Modules\Training\Entities\WorkGroup;
use Modules\Sport\Entities\SportPosition;
use Modules\Generality\Entities\Resource;
use Modules\Health\Entities\TypeMedicine;
use Modules\Test\Entities\TestApplication;
use Modules\Player\Entities\PlayerContract;
use Modules\Health\Entities\PhysicalProblem;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Nutrition\Entities\WeightControl;
use Modules\Sport\Entities\SportPositionSpec;
use Modules\Health\Entities\TobaccoConsumption;
use Modules\Health\Entities\AlcoholConsumption;
use Modules\Nutrition\Entities\NutritionalSheet;
use Modules\Psychology\Entities\PsychologyReport;
use Modules\EffortRecovery\Entities\EffortRecovery;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Player\Database\Factories\PlayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\InjuryPrevention\Entities\InjuryPrevention;

class Player extends Model
{
    use SoftDeletes;
    use HasFactory;

    const LATERALITY_AMBIDEXTROUS = 0;
    const LATERALITY_RIGHT_HANDED = 1;
    const LATERALITY_LEFT_HANDED = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'alias',
        'shirt_number',
        'date_birth',
        'gender_id',
        'gender_identity_id',
        'height',
        'weight',
        'heart_rate',
        'email',
        'agents',
        'user_id',
        'team_id',
        'laterality_id',
        'position_id',
        'position_spec_id',
        'performance_assessment',
        'image_id',
        'position_text',
        'position_spec_text',
        'profile'
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'laterality',
        'bmi',
        'age',
        'gender',
        'gender_identity',
        'max_heart_rate',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'phone' => 'array',
        'mobile_phone' => 'array',
        'agents' => 'array',
    ];

    /**
     * The attributes that are hidden for resulting queries.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot',
    ];

    /**
     * Allways show this relationships
     *
     * @var array
     */
    protected $with = [
        'image'
    ];

    // ---------- CALCULATED ATTRIBUTES ----------

    /**
     * Get the laterality calculated attribute
     */
    public function getLateralityAttribute()
    {
        $lateralities = static::getLateritiesTypes();

        if (!$this->laterality_id) {
            return null;
        }

        $key = array_search($this->laterality_id, array_column($lateralities, 'id'));

        return $lateralities[$key];
    }

    /**
     * Get the body mass index calculated attribute
     */
    public function getBMIAttribute()
    {
        return $this->height > 0
            ? number_format($this->weight / pow($this->height, 2), 2)
            : null;
    }

    /**
     * Get the calculated age attribute
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_birth)->age;
    }

    /**
     * Get the gender value attribute
     */
    public function getGenderAttribute()
    {
        $genders = User::getGenderTypes();

        if (!$this->gender_id) {
            return null;
        }

        $key = array_search($this->gender_id, array_column($genders, 'id'));

        return $genders[$key];
    }

    /**
     * Get the gender identity value attribute
     */
    public function getGenderIdentityAttribute()
    {
        $genders_identity = User::getGenderIdentityTypes();

        if (!$this->gender_identity_id) {
            return null;
        }

        $key = array_search($this->gender_identity_id, array_column($genders_identity, 'id'));

        return $genders_identity[$key];
    }

    /**
     * Calculates the maximum heart rate
     */
    public function getMaxHeartRateAttribute()
    {
        return $this->gender_id === 2
            ? 208.1 - (0.77 * $this->age)
            : 208.7 - (0.73 * $this->age);
    }

    /**
     * Get laterities types
     *
     * @return array
     */
    public static function getLateritiesTypes()
    {
        return [
            [
                "id" => self::LATERALITY_AMBIDEXTROUS,
                "code" => 'ambidextrous',
            ],
            [
                "id" => self::LATERALITY_RIGHT_HANDED,
                "code" => 'right_handed',
            ],
            [
                "id" => self::LATERALITY_LEFT_HANDED,
                "code" => 'left_handed',
            ],
        ];
    }

    // ---------- HELPER FUNCTIONS ----------

    /**
     *
     */
    public function getBasicAtributes()
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'alias' => $this->alias,
            'shirt_number' => $this->shirt_number,
            'email' => $this->email,
        ];
    }

    /**
     * Get the image of the player.
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
     * Get the team the player belongs to.
     */
    public function team()
    {
        return $this->belongsTo(Team::class)->select(
            'id',
            'name',
            'category',
            'club_id',
            'sport_id',
            'modality_id'
        );
    }

    /**
     * Get the position the player desenvolves on the team.
     */
    public function position()
    {
        return $this->belongsTo(SportPosition::class)->select(
            'id',
        )->withTranslation(
            app()->getLocale()
        );
    }

    /**
     * Get the last file fisiotherapy by players.
     */
    public function latestFileFisiotherapy()
    {
        return $this->hasOne(File::class)->latest();
    }

    /**
     * Get the last effort recovery by players.
     */
    public function latestEffortRecovery()
    {
        return $this->hasOne(EffortRecovery::class)->latest();
    }

    /**
     * Get the position the player desenvolves on the team.
     */
    public function position_spec()
    {
        return $this->belongsTo(SportPositionSpec::class)->select(
            'id',
        )->withTranslation(
            app()->getLocale()
        );
    }

    /**
     * Retrieve all the family information related to the user
     */
    public function family()
    {
        return $this->morphOne(Family::class, 'entity');
    }

    /**
     * Retrieve relation with address
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'entity');
    }

    /**
     * Retrieve all contract relationships the player has
     */
    public function contracts()
    {
        return $this->hasMany(PlayerContract::class);
    }

    /**
     * Gets the related user information
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the Player object related to the  nutritional sheet
     *
     * @return Array
     */
    public function nutritional_sheet()
    {
        return $this->HasOne(NutritionalSheet::class);
    }

    /**
     * Returns the Player object related to the weight controls
     *
     * @return Array
     */
    public function weight_controls()
    {
        return $this->HasMany(WeightControl::class);
    }

    /**
     * Returns the Player object related to the weight control
     *
     * @return Array
     */
    public function weight_control()
    {
        return $this->HasOne(WeightControl::class)->latest();
    }

    /**
     * Return a list of related health status
     *
     * @return Array
     */
    public function diseases()
    {
        return $this->morphedByMany(
            Disease::class,
            'health_entity',
            'health_relations',
            'entity_id',
            'health_entity_id'
        );
    }

    /**
     * Return a list of related health status allergies
     *
     * @return Array
     */
    public function allergies()
    {
        return $this->morphedByMany(
            Allergy::class,
            'health_entity',
            'health_relations',
            'entity_id',
            'health_entity_id'
        );
    }

    /**
     * Return a list of related health status body areas
     *
     * @return Array
     */
    public function bodyAreas()
    {
        return $this->morphedByMany(
            AreaBody::class,
            'health_entity',
            'health_relations',
            'entity_id',
            'health_entity_id'
        );
    }

    /**
     * Return a list of related health status on physical problems
     *
     * @return Array
     */
    public function physicalProblems()
    {
        return $this->morphedByMany(
            PhysicalProblem::class,
            'health_entity',
            'health_relations',
            'entity_id',
            'health_entity_id'
        );
    }

    /**
     * Return a list of related health status on medicine types
     *
     * @return Array
     */
    public function medicineTypes()
    {
        return $this->morphedByMany(
            TypeMedicine::class,
            'health_entity',
            'health_relations',
            'entity_id',
            'health_entity_id'
        );
    }

    /**
     * Return a list of related health status on tobacco consumptions
     *
     * @return Array
     */
    public function tobaccoConsumptions()
    {
        return $this->morphedByMany(
            TobaccoConsumption::class,
            'health_entity',
            'health_relations',
            'entity_id',
            'health_entity_id'
        );
    }

    /**
     * Return a list of related health status on alcohol consumptions
     *
     * @return Array
     */
    public function alcoholConsumptions()
    {
        return $this->morphedByMany(
            AlcoholConsumption::class,
            'health_entity',
            'health_relations',
            'entity_id',
            'health_entity_id'
        );
    }

    /**
     * Return a list of all related injuries to the player
     *
     * @return Array
     */
    public function injuries()
    {
        return $this->morphMany(Injury::class, 'entity');
    }

    /**
     * Return a list of all related surgeries to the player
     *
     * @return Array
     */
    public function surgeries()
    {
        return $this->morphMany(Surgery::class, 'entity')->with('disease');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PlayerFactory::new();
    }

    /**
     * Returns a list of workGroupd objects related to the  Player
     *
     * @return Array
     */
    public function workGroups()
    {
        return $this->morphMany(WorkGroup::class, 'applicant');
    }

    /**
     * Return the list of specific related entities attached to all
     * activities envolved by the player
     *
     * @return Array
     */
    public function getRelatedActivtyEntities()
    {
        return [
            [
                'entity_class' => 'club',
                'entity_id' => $this->team->club_id
            ],
            [
                'entity_class' => 'team',
                'entity_id' =>  $this->team->id,
            ]
        ];
    }

    /**
     * Relation many with PsychologyReport
     * @return HasMany
     */
    public function psychologyReports()
    {
        return $this->hasMany(PsychologyReport::class)->orderBy('date', 'desc');
    }

    /**
     * Returns a list of skills objects related to the  Player
     *
     * @return Array
     */
    public function skills()
    {
        return $this->belongsToMany(
            Skills::class,
            'player_skills'
        )->withTimestamps();
    }

    /**
     * Returns all the files related to a player fisiotherapy
     *
     * @return Array
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * Returns all the player injury prevention related data
     *
     * @return Array
     */
    public function injuryPreventions()
    {
        return $this->hasMany(InjuryPrevention::class)
            ->orderBy('is_finished', 'asc')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Return all the effort recovery items made to the player item
     *
     * @return Array
     */
    public function effortRecovery()
    {
        return $this->hasOne(EffortRecovery::class)
            ->with('questionnaireHistory');
    }

    /**
     * Relation many with test application
     * @return morphMany
     */
    public function testApplications()
    {
        return $this->morphMany(TestApplication::class, 'applicant');
    }

    /**
     * Relation one with lastest test application
     * @return morphOne
     */
    public function latestTestApplication()
    {
        return $this->morphOne(TestApplication::class, 'applicant')->latestOfMany()
            ->select(
                'test_applications.applicant_id',
                'test_applications.applicant_type',
                'test_applications.date_application',
                'test_id'
            );
    }
}
