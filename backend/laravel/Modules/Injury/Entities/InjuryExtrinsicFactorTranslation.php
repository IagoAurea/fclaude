<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;

class InjuryExtrinsicFactorTranslation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_extrinsic_factor_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
