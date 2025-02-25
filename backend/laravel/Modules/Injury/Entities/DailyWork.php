<?php

namespace Modules\Injury\Entities;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="DailyWork",
 *      description="DailyWork model",
 *      @OA\Xml( name="DailyWork"),
 *      @OA\Property( title="Day", property="day", description="date of work ", format="date", example="2021-10-21" ),
 *      @OA\Property( title="Duration", property="duration", description="duration of work", format="string", example="05:00" ),
 *      @OA\Property( title="Rpe", property="rpe", description="evaluation rpe", format="integer", example="10" ),
 *      @OA\Property( title="Test", property="test", description="tests performed", format="string", example="Dancing" ),     
 *      @OA\Property( title="Description", property="description", description="description to daily work", format="string", example="this is a description" ),
 *      @OA\Property( title="Rfd", property="injury_rfd_id", description="rfd associate", format="integer", example="1" ),
 *      @OA\Property( title="Prueba de control", property="control_test", description="control test", format="boolean", example="true" )
 * )
 */
class DailyWork extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_works';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day',
        'duration',
        'rpe',
        'test',
        'description',
        'training_load',
        'monotony',
        'training_strain',
        'injury_rfd_id',
        'control_test'
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
     * Returns the injury rfd object related to the  Daily Work
     * 
     * @return Array
     */
    public function injury_rfd () 
    {
        return $this->belongsTo(InjuryRfd::class);
    }

}
