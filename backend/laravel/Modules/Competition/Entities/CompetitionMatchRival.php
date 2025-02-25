<?php

namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;

class CompetitionMatchRival extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'competition_match_rivals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_match_id',
        'rival_player',
    ];

    /**
     * Hiding fields
     * @var string[]
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
