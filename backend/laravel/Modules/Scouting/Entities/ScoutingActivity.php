<?php

namespace Modules\Scouting\Entities;

use Modules\Scouting\Database\Factories\ScoutingActivityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Scouting\Entities\Scouting;
use Illuminate\Database\Eloquent\Model;
use Modules\Player\Entities\Player;

class ScoutingActivity extends Model
{
    use HasFactory, SoftDeletes;

    const WINNER = 'WINNER';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scouting_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'scouting_id',
        'player_id',
        'action_id',
        'in_game_time',
        'status',
        'custom_params'
    ];

    protected $with = ['action'];

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
     * Relation with player
     * 
     * @return BelongsTo
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Relation with action
     * 
     * @return BelongsTo
     */
    public function action()
    {
        return $this->belongsTo(Action::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ScoutingActivityFactory::new();
    }
}
