<?php

namespace Modules\Competition\Entities;

use Modules\Player\Entities\Player;
use Illuminate\Database\Eloquent\Model;
use Modules\Player\Entities\LineupPlayerType;
use Modules\Training\Entities\SubjecPerceptEffort;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompetitionMatchPlayer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'competition_match_players';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_match_id',
        'player_id',
        'lineup_player_type_id',
        'perception_effort_id',
        'order'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relation with Players
     * @return BelongsTo
     */
    public function player()
    {
        return $this->belongsTo(Player::class)
            ->select('id', 'full_name', 'alias', 'shirt_number', 'image_id', 'gender_id');
    }

    /**
     * Relation with Type Players
     * @return BelongsTo
     */
    public function lineupPlayerType()
    {
        return $this->belongsTo(LineupPlayerType::class);
    }

    /**
     * Relation with CompetitionMatch
     * @return BelongsTo
     */
    public function competitionMatch()
    {
        return $this->belongsTo(CompetitionMatch::class);
    }

    /**
     * Relation with SubjecPerceptEffort
     * @return BelongsTo
     */
    public function perceptEffort()
    {
        return $this->belongsTo(SubjecPerceptEffort::class, 'perception_effort_id', 'id');
    }
}
