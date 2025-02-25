<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;

class InjuriesIntrinsicFactor extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injuries_intrinsic_factors';

    /**
     * Incrementing column id
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'injury_id',
        'injury_intrinsic_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
