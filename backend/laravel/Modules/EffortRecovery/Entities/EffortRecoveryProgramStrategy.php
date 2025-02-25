<?php

namespace Modules\EffortRecovery\Entities;

use Illuminate\Database\Eloquent\Model;

class EffortRecoveryProgramStrategy extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'effort_recovery_programs_strategies';

    /**
     * Table primary key name type.
     * 
     * @var int
     */
    protected $primaryKey = null;

    /**
     * Determines incrementing behavior on table insertions.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'effort_recovery_id',
        'effort_recovery_strategy_id'
    ];
}
