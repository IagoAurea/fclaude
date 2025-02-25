<?php


namespace Modules\Competition\Entities;

use Modules\Team\Entities\Team;
use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Resource;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Competition\Database\Factories\CompetitionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competition extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'competitions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'name',
        'image_id',
        'type_competition_id',
        'date_start',
        'date_end',
        'state'
    ];

    /**
     * Additional Fields as transient
     * @var string[]
     */
    protected $appends = [
        "type_competition_name"
    ];

    /**
     * Hiding fields
     * @var string[]
     */
    protected $hidden = [
    ];

    /**
     * Getting image associated
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Getting type competition associated
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeCompetition()
    {
        return $this->belongsTo(TypeCompetition::class)->withTranslation(app()->getLocale());
    }

    /**
     * Getting team associated
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class)->select(
            'id', 'code', 'name', 'color', 'image_id', 'cover_id', 'club_id', 'sport_id'
        );
    }

    /**
     * Get rivalTeams associated
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rivalTeams()
    {
        return $this->hasMany(CompetitionRivalTeam::class);
    }

    public function getTypeCompetitionNameAttribute()
    {
        return $this->typeCompetition ? $this->typeCompetition->name : null;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CompetitionFactory::new();
    }

    /**
     * Return a list of related matches to the competition
     * 
     * @return array
     */
    public function matches()
    {
        $matches = $this->hasMany(CompetitionMatch::class)->with(
            'competitionRivalTeam', 'referee', 'weather'
        )->orderBy('start_at', 'asc');

        return $matches;
    }
}
