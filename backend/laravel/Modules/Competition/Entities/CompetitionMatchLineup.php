<?php


namespace Modules\Competition\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Team\Entities\TypeLineup;

class CompetitionMatchLineup extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'competition_match_lineups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_match_id',
        'type_lineup_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relation with competition
     * @return BelongsTo
     */
    public function competitionMatch()
    {
        return $this->belongsTo(CompetitionMatch::class);
    }

    /**
     * Returns related lineup type
     * @return object
     */
    public function typeLineup()
    {
        return $this->belongsTo(TypeLineup::class);
    }
}
