<?php

namespace Modules\Scouting\Entities;

use Modules\Scouting\Database\Factories\ScoutingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Entities\ScoutingResult;
use Illuminate\Database\Eloquent\Model;

class Scouting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'scoutings';
    
    /**
     * Dates to be casted
     */
    protected $dates = [
        'start_date',
        'finish_date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'in_game_time',
        'in_period_time',
        'in_real_time',
        'status',
        'start_date',
        'finish_date',
        'status',
        'competition_match_id',
        'start_match',
        'custom_params'
    ];

    const STATUS_NOT_STARTED = 'NOT_STARTED';
    const STATUS_STARTED = 'STARTED';
    const STATUS_PAUSED = 'PAUSED';
    const STATUS_FINISHED = 'FINISHED';

    /**
     * Relation with competition
     *
     * @return BelongsTo
     */
    public function competitionMatch()
    {
        return $this->belongsTo(CompetitionMatch::class);
    }

    /**
     * Relation with scouting activities
     *
     * @return HasMany
     */
    public function scoutingActivities()
    {
        return $this->hasMany(ScoutingActivity::class);
    }

    /**
     * Relation with scouting results
     *
     * @return BelongsTo
     */
    public function scoutingResults()
    {
        return $this->hasOne(ScoutingResult::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ScoutingFactory::new();
    }
}
