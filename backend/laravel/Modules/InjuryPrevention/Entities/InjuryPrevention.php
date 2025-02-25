<?php

namespace Modules\InjuryPrevention\Entities;

use Modules\Player\Entities\Player;
use Modules\Staff\Entities\StaffUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Generality\Entities\WeekDay;
use Modules\Injury\Entities\InjuryLocation;
use Modules\InjuryPrevention\Entities\EvaluationQuestion;
use Modules\InjuryPrevention\Entities\PreventiveProgramType;
use Modules\Calculator\Entities\CalculatorEntityAnswerHistoricalRecord;

/**
 * @OA\Schema(
 *      title="InjuryPrevention",
 *      description="Injury Prevention model",
 *      @OA\Xml( name="InjuryPrevention"),
 *      @OA\Property(
 *          title="Title",
 *          property="title",
 *          description="Injury prevention title",
 *          format="string",
 *          example="Preventing Head Injury"
 *      ),
 *      @OA\Property(
 *          title="Detailed Location",
 *          property="detailed_location",
 *          description="Description of the injury location",
 *          format="string",
 *          example="Head"
 *      ),
 *      @OA\Property(
 *          title="Description",
 *          property="description",
 *          description="Describes more specifications about the injury",
 *          format="string",
 *          example="Injury affects the low bodyparts"
 *      ),
 *      @OA\Property(
 *          title="Player ID",
 *          property="player_id",
 *          description="Is the identificator of related player",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Team Staff ID",
 *          property="team_staff_id",
 *          description="Is the identificator of related team staff member",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Preventive Program Type ID",
 *          property="preventive_program_type_id",
 *          description="Is the identificator of related type of preventive program",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Injury Location ID",
 *          property="injury_location_id",
 *          description="Is the identificator of related injury body location",
 *          format="int64",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Is Finished",
 *          property="is_finished",
 *          description="Checks if the preventive program is already finished",
 *          format="boolean",
 *          example="1"
 *      )
 * )
 */
class InjuryPrevention extends Model
{
    use SoftDeletes;

    /**
     * Needed constants for profile result
     */
    const LOW_PROFILE = 'low';
    const HIGH_PROFILE = 'high';
    const NONE_PROFILE = 'none';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_preventions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'detailed_location',
        'description',
        'player_id',
        'team_staff_id',
        'preventive_program_type_id',
        'injury_location_id',
        'is_finished',
        'evaluation_points',
        'profile_status',
        'end_date',
        'other_preventive_program_type',
        'user_id'
    ];

    /**
     * The attributes that are hidden for resulting queries.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];


    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // ---- Relationships
    /**
     * Retrieves informations about player related to the prevention item
     *
     * @return Array
     */
    public function player()
    {
        return $this->belongsTo(Player::class)
            ->select(
                'id',
                'date_birth',
                'full_name',
                'alias',
                'height',
                'weight',
                'gender_id',
                'shirt_number',
                'image_id',
                'team_id'
            )
            ->with('image');
    }

    /**
     * Retrieves informations about player related to the prevention item
     *
     * @return Array
     */
    public function teamStaff()
    {
        return $this->belongsTo(StaffUser::class)->select('id', 'full_name');
    }

    /**
     * Retrieves informations about player related to the prevention item
     *
     * @return Array
     */
    public function preventiveProgramType()
    {
        return $this->belongsTo(PreventiveProgramType::class);
    }

    /**
     * Retrieves all evaluation question answers
     *
     * @return Array
     */
    public function evaluationQuestionAnswers()
    {
        return $this->belongsToMany(EvaluationQuestion::class, 'injury_prevention_evaluation_answers')
            ->withPivot('value');
    }

    /**
     * Return a list of related activities
     *
     * @return Array
     */
    public function calculatorEntityAnswerHistoricalRecords()
    {
        return $this->morphMany(CalculatorEntityAnswerHistoricalRecord::class, 'entity')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Return a lsit of related week days
     *
     * @return Array
     */
    public function weekDays()
    {
        return $this->belongsToMany(WeekDay::class, 'injury_prevention_week_days');
    }

    /**
     * Returns related injury location
     *
     * @return Object
     */
    public function injuryLocation()
    {
        return $this->belongsTo(InjuryLocation::class);
    }
}
