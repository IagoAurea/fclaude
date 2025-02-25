<?php

namespace Modules\Scouting\Entities;

use Modules\Scouting\Entities\Scouting;
use Illuminate\Database\Eloquent\Model;

class ScoutingResult extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scouting_results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scouting_id',
        'in_game_time',
        'data',
        'use_tool'
    ];

    /**
     * Relation with scouting
     * 
     * @return BelongsTo
     */
    public function scouting()
    {
        return $this->belongsTo(Scouting::class);
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}
