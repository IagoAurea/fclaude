<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;

class InjuriesExtrinsicFactor extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injuries_extrinsic_factors';

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
        'injury_extrinsic_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
