<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
use App\Traits\TranslationTrait;
use Modules\Health\Entities\AreaBody;
use Modules\Injury\Entities\InjuryType;
use Modules\Injury\Entities\InjurySeverity;
use Modules\Injury\Entities\InjuryLocation;
use Modules\Injury\Entities\InjuryTypeSpec;
use Modules\Injury\Entities\InjurySituation;
use Modules\Injury\Entities\MechanismInjury;
use Modules\Injury\Entities\ClinicalTestType;
use Modules\Injury\Entities\InjuryExtrinsicFactor;
use Modules\Injury\Entities\InjuryIntrinsicFactor;

/**
 * @OA\Schema(
 *      title="Injury",
 *      description="Injury model",
 *      @OA\Xml( name="Injury"),
 *      @OA\Property(title="Injury date", property="injury_date", description="injury date", format="date", example="2021-10-21" ),
 *      @OA\Property(title="Injury day", property="injury_day", description="injury day", format="integer", example="1" ),
 *      @OA\Property(title="Mechanism injury", property="mechanism_injury_id", description="injury mechanism", format="int64", example="1" ),
 *      @OA\Property(title="Situation injury", property="injury_situation_id", description="injury situation", format="int64", example="1" ),
 *      @OA\Property(title="Is triggered by contac", property="is_triggered_by_contac", description="triggered by contac", format="boolean", example="true" ),
 *      @OA\Property(title="Type injury", property="injury_type_id", description="type of injury", format="int64", example="1" ),
 *      @OA\Property(title="Type spec injury", property="injury_type_spec_id", description="type spec of injury", format="int64", example="1" ),
 *      @OA\Property(title="Detailed diagnose", property="detailed_diagnose", description="detailed diagnose", format="string", example="Lorem ipsusssm" ),
 *      @OA\Property(title="Area body", property="area_body_id", description="area body", format="int64", example="1" ),
 *      @OA\Property(title="Detailed location", property="detailed_location", description="detailed location", format="string", example="More lorem ipsum" ),
 *      @OA\Property(title="Affected side", property="affected_side_id", description="affected side", format="int64", example="1" ),
 *      @OA\Property(title="Injury severity", property="injury_severity_id", description="injury severity", format="int64", example="1" ),
 *      @OA\Property(title="Relapse", property="is_relapse", description="is relapse", format="boolean", example="true" ),
 *      @OA\Property(title="Injury location", property="injury_location_id", description="injury location", format="int64", example="1" ),
 *      @OA\Property(title="Injury forecast", property="injury_forecast", description="injury forecast", format="string", example="More forecast lorem ipsum" ),
 *      @OA\Property(title="Days off", property="days_off", description="days off", format="int", example="20" ),
 *      @OA\Property(title="Matches off", property="matches_off", description="matches off", format="int", example="4" ),
 *      @OA\Property(title="Medically discharged date", property="medically_discharged_at", description="medically discharged date", format="date", example="2021-10-16" ),
 *      @OA\Property(title="Sportly discharged date", property="sportly_discharged_at", description="sportly discharged date", format="date", example="2021-11-21" ),
 *      @OA\Property(title="Competitively discharged date", property="competitively_discharged_at", description="competitively discharged date", format="date", example="2021-12-21" ),
 *      @OA\Property(title="Surgery date", property="surgery_date", description="surgery date", format="date", example="2021-10-21" ),
 *      @OA\Property(title="Surgeon name", property="surgeon_name", description="surgeon name", format="string", example="Dr. Jose Gregorio Hernandez" ),     
 *      @OA\Property(title="Medical center name", property="medical_center_name", description="medical center name", format="string", example="Dr. Jose Gregorio Hernandez" ),     
 *      @OA\Property(title="Surgery extra info", property="surgery_extra_info", description="surgery extra info", format="string", example="Surgery lorem ipsum information" ),     
 *      @OA\Property(title="Extra info", property="extra_info", description="extra info", format="string", example="extra information" ),     
 *      @OA\Property(title="Clinical test types", property="clinical_test_types", description="clinical test types", format="array", example="[1, 2, 3]" ),
 *      @OA\Property(title="Injury extrinsic factor", property="injury_extrinsic_factor", description="injury extrinsic factor", format="array", example="[1, 2, 3]" ),
 *      @OA\Property(title="Injury intrinsic factor", property="injury_intrinsic_factor", description="injury intrinsic factor", format="array", example="[1, 2, 3]" )
 * )
 */
class Injury extends Model
{
    use SoftDeletes, TranslationTrait;

    const AFFECTED_SIDE_TYPE_RIGHT = 0;
    const AFFECTED_SIDE_TYPE_LEFT = 1;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injuries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_type',
        'entity_id',
        'injury_date',
        'injury_day',
        'mechanism_injury_id',
        'injury_situation_id',
        'is_triggered_by_contact',
        'injury_type_id',
        'injury_type_spec_id',
        'detailed_diagnose',
        'area_body_id',
        'detailed_location',
        'affected_side_id', // Non-relational type
        'is_relapse',
        'injury_severity_id',
        'injury_location_id',
        'injury_forecast',
        'days_off',
        'matches_off',
        'medically_discharged_at',
        'sportly_discharged_at',
        'competitively_discharged_at',
        'surgery_date',
        'surgeon_name',
        'medical_center_name',
        'surgery_extra_info',
        'extra_info',
        'is_active',
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'affected_side',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * The attributes that are hidden for resulting queries.
     *
     * @var array
     */
    protected $hidden = [
        'entity_type',
        'entity_class',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

     /**
     * Register any events.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        static::creating(function($model) {
            $now = Carbon::now();

            $injury_date = Carbon::parse($model->injury_date);
    
            $model->injury_day = $injury_date->diffInDays($now);
        });
    }

    /**
     * Get affected side types
     *
     * @return array
     */
    public static function getAffectedSideTypes()
    {
        return [
            [
                "id" => self::AFFECTED_SIDE_TYPE_RIGHT,
                "code" => 'affected_side_right',
                "name" =>__('messages.right')
            ],
            [
                "id" => self::AFFECTED_SIDE_TYPE_LEFT,
                "code" => 'affected_side_left',
                "name" => __('messages.left')
            ],
        ];
    }

    /**
     * Gets the affected_side attribute
     *
     * @return Object|Array
     */
    public function getAffectedSideAttribute()
    {
        $sides = static::getAffectedSideTypes();

        $key = array_search($this->affected_side_id, array_column($sides, 'id'));

        return $sides[$key];
    }

    // -- Relationships

    /**
     * Get the relational entity
     *
     * @return Array|Object
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Get the intrinsic factor
     *
     * @return Array|Object
     */
    public function intrinsicFactor()
    {
        return $this->belongsToMany(
            InjuryIntrinsicFactor::class, 'injuries_intrinsic_factors',  'injury_id', 'injury_intrinsic_id');

    }

    /**
     * Get the extrinsic factor
     *
     * @return Array|Object
     */
    public function extrinsicFactor()
    {
        return $this->belongsToMany(InjuryExtrinsicFactor::class,
            'injuries_extrinsic_factors',  'injury_id', 'injury_extrinsic_id');
    }

    /**
     * Get the mechanism related
     *
     * @return Array|Object
     */
    public function mechanism()
    {
        return $this->belongsTo(MechanismInjury::class, 'mechanism_injury_id');
    }

    /**
     * Get the severity related
     *
     * @return Array|Object
     */
    public function severity()
    {
        return $this->belongsTo(InjurySeverity::class, 'injury_severity_id');
    }

    /**
     * Get the location related
     *
     * @return Array|Object
     */
    public function location()
    {
        return $this->belongsTo(InjuryLocation::class, 'injury_location_id');
    }

    /**
     * Get the type related
     *
     * @return Array|Object
     */
    public function type()
    {
        return $this->belongsTo(InjuryType::class, 'injury_type_id');
    }

    /**
     * Get the type spec related
     *
     * @return Array|Object
     */
    public function typeSpec()
    {
        return $this->belongsTo(InjuryTypeSpec::class, 'injury_type_spec_id');
    }

    /**
     * Get the location related
     *
     * @return Array|Object
     */
    public function areaBody()
    {
        return $this->belongsTo(AreaBody::class);
    }

    /**
     * Get the clinical test types relationship
     *
     * @return Array
     */
    public function clinicalTestTypes()
    {
        return $this->belongsToMany(ClinicalTestType::class, 'injury_clinical_test_types');
    }

    /**
     * Get the injury situation type
     *
     * @return Array|Object
     */
    public function injurySituation()
    {
        return $this->belongsTo(InjurySituation::class);
    }

    /**
     * Returns the player injury object related to the  injury rfd
     *
     * @return Array
     */
    public function rfd()
    {
        return $this->hasOne(InjuryRfd::class);
    }
}
