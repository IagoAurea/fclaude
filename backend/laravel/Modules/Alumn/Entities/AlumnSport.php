<?php

namespace Modules\Alumn\Entities;

use Illuminate\Database\Eloquent\Model;

class AlumnSport extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'alumns_sports';

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
     * The attributes that are hidden from querying.
     *
     * @var array
     */
    protected $hidden = [
        'pivot',
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alumn_id',
        'sport_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
