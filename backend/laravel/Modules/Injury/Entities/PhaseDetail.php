<?php

namespace Modules\Injury\Entities;

use Illuminate\Support\Str;
use Modules\Injury\Entities\Phase;
use Modules\Staff\Entities\StaffUser;
use Modules\Injury\Entities\InjuryRfd;
use Modules\Injury\Entities\CurrentSituation;
use Illuminate\Database\Eloquent\Model;
use Modules\Test\Entities\TestApplication;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="PhaseDetail",
 *      description="PhaseDetail model",
 *      @OA\Xml( name="PhaseDetail"),
 *      @OA\Property( title="Injury Rfd", property="injury_rfd_id",
 *          description="rfd related", format="integer", example="1" ),
 *      @OA\Property( title="Phase", property="phase_id",
 *          description="Phase  related ", format="integer", example="1" ), 
 *      @OA\Property( title="Professional directs", property="professional_directs_id",
 *          description="Professional related", format="integer", example="1" ),
 *      @OA\Property( title="Current Situation", property="current_situation_id",
 *          description="Actual status ", format="integer", example="1" ),
 *      @OA\Property( title="Test Passed", property="test_passed",
 *          description="indicator test passed", format="boolean", example="true" ),
 *      @OA\Property( title="Not Pain", property="not_pain",
 *          description="indicator pain", format="boolean", example="true" ),
 *      @OA\Property( title="Percentage Complete", property="percentage_complete",
 *          description="percentage complete", format="double", example="84.5" ),
 *      @OA\Property( title="Phase Passed", property="phase_passed",
 *          description="indicator passed", format="boolean", example="true" ),
 *      @OA\Property( title="Sport", property="sport_id",
 *          description="sport_associate ", format="integer", example="1" ),
 * * )
 */
class PhaseDetail extends Model
{
    use SoftDeletes;

    protected $morphClass = 'PhaseDetail';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'phase_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'injury_rfd_id',
        'phase_id',
        'professional_directs_id',
        'current_situation_id',
        'test_passed',
        'not_pain',
        'percentage_complete',
        'phase_passed',
        'sport_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
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
     * Register any events.
     *
     * @return void
     */
    public static function boot() {
        parent::boot();

        static::creating(function($model) {
            $model->code = Str::uuid()->toString();
        });
    }

    public function test_application()
    {
        return $this->morphOne(TestApplication::class, 'applicable');
    }

    /**
     * Returns the injury rfd object related to the  phase detail
     *
     * @return Array
     */
    public function injury_rfd() 
    {
        return $this->belongsTo(InjuryRfd::class);
    }

    /**
     * Returns the phase object related to the  phase detail
     * 
     * @return Array
     */
    public function phase() 
    {
        return $this->belongsTo(Phase::class);
    }

    /**
     * Returns the phase object related to the  phase detail
     *
     * @return Array
     */
    public function professional_direct() 
    {
        return $this->belongsTo(StaffUser::class);
    }

    /**
     * Returns the current situation object related to the  injury rfd
     *
     * @return Array
     */
    public function current_situation() 
    {
        return $this->belongsTo(CurrentSituation::class);
    }
}
