<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;

class SubpackageSport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subpackage_sports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subpackage_id',
        'sport_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
