<?php

namespace Modules\Injury\Entities;

use Illuminate\Support\Str;
use Modules\Injury\Entities\Injury;
use Modules\Injury\Entities\DailyWork;
use Illuminate\Database\Eloquent\Model;
use Modules\Injury\Entities\PhaseDetail;
use Modules\Injury\Entities\CurrentSituation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Injury\Entities\ReinstatementCriteria;

/**
 * @OA\Schema(
 *      title="InjuryRfd",
 *      description="InjuryRfd model",
 *      @OA\Xml( name="InjuryRfd"),
 *      @OA\Property( title="Code", property="code",
 *          description="code to identify", format="string", example="7562b718-4b54-46f2-8ec4-ece91c351529" ),
 *      @OA\Property( title="Injury", property="injury_id",
 *          description="Injury related", format="integer", example="1" ),
 *      @OA\Property( title="Percentage Complete",
 *          property="percentage_complete", description="percentage of completion", format="double", example="84.5" ),
 *      @OA\Property( title="Current Situation",
 *          property="current_situation_id", description="Current Situation to RFD", format="integer", example="6" ),
 *      @OA\Property( title="Annotations", property="annotations",
 *          description="observations", format="string", example="this rfd is..." ),
 *      @OA\Property( title="Code", property="closed",
 *          description="RFD Status", format="boolean", example="True" )
 * * )
 */
class InjuryRfd extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_rfds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'injury_id',
        'percentage_complete',
        'current_situation_id',
        'annotations',
        'closed',
        'user_id'
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

    /**
     * Returns the player injury object related to the  injury rfd
     *
     * @return Array
     */
    public function injury()
    {
        return $this->belongsTo(Injury::class);
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

    /**
     * Returns the daily works objects related to the  injury rfd
     *
     * @return Array
     */
    public function daily_works()
    {
        return $this->HasMany(DailyWork::class);
    }

    /**
     * Returns the reinstatement criterias object related to the  rfd
     *
     * @return Array
     */

    public function criterias()
    {
        return $this->belongsToMany(
            ReinstatementCriteria::class, 'injury_rfd_criterias'
        )->withTimestamps()->withPivot('value');
    }

    /**
     * Returns the criterias  object related to the  injury rfd
     *
     * @return Array
     */
    public function phase_details()
    {
        return $this->HasMany(PhaseDetail::class);
    }
}
