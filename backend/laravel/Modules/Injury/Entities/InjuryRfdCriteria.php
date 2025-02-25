<?php

namespace Modules\Injury\Entities;

use Illuminate\Support\Str;
use Modules\Injury\Entities\InjuryRfd;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Injury\Entities\ReinstatementCriteria;

/**
 * @OA\Schema(
 *      title="InjuryRfdCriteria",
 *      description="InjuryRfdCriteria model",
 *      @OA\Xml( name="InjuryRfdCriteria"),
 *      @OA\Property( title="Injury Rfd", property="injury_rfd_id",
 *          description="rfd related", format="integer", example="1" ),
 *      @OA\Property( title="Reinstatement Criteria", property="reinstatement_criteria_id",
 *          description="reinstatement criteria related", format="integer", example="1" ),
 *      @OA\Property( title="Value", property="value",
 *          description="true or false value", format="boolean", example="True" ) 
 * * )
 */
class InjuryRfdCriteria extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_rfd_criterias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'injury_rfd_id',
        'reinstatement_criteria_id',
        'value'
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
     * Returns the current situation object related to the  injury rfd
     * 
     * @return Array
     */
    public function injury_rfd () 
    {
        return $this->belongsTo(InjuryRfd::class);
    }

    /**
     * Returns the current situation object related to the  injury rfd
     * 
     * @return Array
     */
    public function reinstatement_criteria () 
    {
        return $this->belongsTo(ReinstatementCriteria::class);
    }
}
