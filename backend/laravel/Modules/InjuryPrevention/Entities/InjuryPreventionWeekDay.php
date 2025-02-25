<?php

namespace Modules\InjuryPrevention\Entities;

use Illuminate\Database\Eloquent\Model;

class InjuryPreventionWeekDay extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_prevention_week_days';

    /**
     * Determines the primary key used for the model table.
     *
     * @var string
     */
    protected $primaryKey = null;

    /**
     * Determines incrementing behavior on table insertions.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Determines if current model uses default timestamps.
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
        'injury_prevention_id',
        'week_day_id'
    ];
}
