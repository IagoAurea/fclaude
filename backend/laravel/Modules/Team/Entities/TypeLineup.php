<?php

namespace Modules\Team\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Modules\Sport\Entities\Sport;

class TypeLineup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'type_lineups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sport_id',
        'modality_id',
        'lineup',
        'total_players'
    ];

    /**
     * The attributes that must not be showable to the user.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation with Sport
     * @return BelongsTo
     */
    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    /**
     * Relation with TeamModality
     * @return BelongsTo
     */
    public function modality()
    {
        return $this->belongsTo(TeamModality::class);
    }
}
