<?php

namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;

class TypeCompetitionSport extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_competition_sports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type_competition_id',
        'sport_id',
    ];

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

}
