<?php

namespace Modules\Alumn\Entities;

use Carbon\Carbon;
use Modules\User\Entities\User;
use Modules\Sport\Entities\Sport;
use Modules\Family\Entities\Family;
use Modules\Injury\Entities\Injury;
use Modules\Health\Entities\Disease;
use Modules\Health\Entities\Surgery;
use Modules\Health\Entities\Allergy;
use Modules\Health\Entities\AreaBody;
use Modules\Address\Entities\Address;
use Illuminate\Database\Eloquent\Model;
use Modules\Classroom\Entities\Subject;
use Modules\Generality\Entities\Resource;
use Modules\Health\Entities\TypeMedicine;
use Modules\Tutorship\Entities\Tutorship;
use Modules\Test\Entities\TestApplication;
use Modules\Health\Entities\PhysicalProblem;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Health\Entities\TobaccoConsumption;
use Modules\Health\Entities\AlcoholConsumption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Classroom\Entities\ClassroomAcademicYear;

class Alumn extends Model
{
    use SoftDeletes, HasFactory;

    const LATERALITY_AMBIDEXTROUS = 0;
    const LATERALITY_RIGHT_HANDED = 1;
    const LATERALITY_LEFT_HANDED = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'list_number',
        'full_name',
        'gender_id',
        'date_birth',
        'height',
        'weight',
        'heart_rate',
        'email',
        'country_id',
        'academical_emails',
        'virtual_space',
        'is_new_entry',
        'is_advanced_course',
        'is_repeater',
        'is_delegate',
        'is_sub_delegate',
        'has_digital_difficulty',
        'acneae_type_text',
        'acneae_type_id',
        'acneae_subtype_id',
        'acneae_description',
        'has_sport',
        'has_extracurricular_sport',
        'has_federated_sport',
        'laterality_id',
        'user_id',
        'image_id',
        'favorite_sport_id',
        'gender_identity_id'
    ];

    protected $with = [
        'image',
        'favoriteSport'
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
        'has_pending_physical_education',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'academical_emails' => 'array',
        'virtual_space' => 'array',
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
     * Get the laterality calculated attribute
     */
    public function getLateralityAttribute()
    {
        $lateralities = static::getLateritiesTypes();

        if (is_null($this->laterality_id)) { return null; }

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
        return Carbon::parse($this->birthdate)->age;
    }

    /**
     * Get the gender value attribute
     */
    public function getGenderAttribute()
    {
        $genders = User::getGenderTypes();

        if (is_null($this->gender_id)) { return null; }

        $key = array_search($this->gender_id, array_column($genders, 'id'));

        return $genders[$key];
    }

    
    /**
     * Get the gender identity value attribute
     */
    public function getGenderIdentityAttribute()
    {
        $genders_identity = User::getGenderIdentityTypes();

        if (is_null($this->gender_identity_id)) { return null; }

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
     * Calculates the maximum heart rate
     */
    public function getHasPendingPhysicalEducationAttribute()
    {
        return $this->pendingSubjects->contains(function ($value) {
            return $value->is_physical_education == true;
        });
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
     * Retrieve all the family information related to the user
     */
    public function family()
    {
        return $this->morphOne(Family::class, 'entity');
    }

    /**
     *Retrieve address alumn
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'entity');
    }

    /**
     * Gets the related user information
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
     * Get related sports
     *
     * @return Array
     */
    public function favoriteSport()
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Get related sports
     *
     * @return Array
     */
    public function sports()
    {
        return $this->belongsToMany(Sport::class, 'alumns_sports');
    }

    /**
     * Get related subjects
     *
     * @return Array
     */
    public function pendingSubjects()
    {
        return $this->belongsToMany(Subject::class, 'alumns_subjects');
    }

    /**
     * Get related academic years
     *
     * @return Array
     */
    public function academicYears()
    {
        return $this->belongsToMany(ClassroomAcademicYear::class, 'classroom_academic_year_alumns');
    }

    /**
     * Get related tutorhsips
     *
     * @return Array
     */
    public function tutorships()
    {
        return $this->hasMany(Tutorship::class)->orderBy('id', 'DESC');
    }

    /**
     * Relation with acneae type
     *
     * @return BelongsTo
     */
    public function acneaeType()
    {
        return $this->belongsTo(AcneaeType::class);
    }

    /**
     * Relation with acneae subtype
     *
     * @return BelongsTo
     */
    public function acneaeSubtype()
    {
        return $this->belongsTo(AcneaeSubtype::class);
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
                'test_applications.applicant_id', 'test_applications.applicant_type',
                'test_applications.date_application', 'test_id'
            );
    }
}
