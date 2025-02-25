<?php


namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Scouting\Entities\Scouting;
use Modules\Generality\Entities\Weather;
use Modules\Generality\Entities\Referee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Competition\Entities\TypeModalityMatch;
use Modules\Competition\Entities\TestCategoryMatch;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Competition\Entities\TestTypeCategoryMatch;
use Modules\Competition\Entities\CompetitionMatchRival;
use Modules\Competition\Entities\CompetitionMatchLineup;
use Modules\Competition\Entities\CompetitionMatchPlayer;
use Modules\Competition\Database\Factories\CompetitionMatchFactory;

class CompetitionMatch extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'competition_matches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'start_at',
        'location',
        'observation',
        'competition_rival_team_id',
        'match_situation', // L or V
        'referee_id',
        'weather_id',
        'test_category_id',
        'test_type_category_id',
        'modality_id'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'start_at'
    ];

    /**
     * Additional fields as transient
     * @var string[]
     */
    protected $appends = [
        "competition_name",
        "competition_url_image"
    ];

    /**
     * Hiding fields
     * @var string[]
     */
    protected $hidden = [

    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    // ---------- Relationships

    /**
     * Relation with Competition
     * @return BelongsTo
     */
    public function scouting()
    {
        return $this->hasOne(Scouting::class);
    }

    /** Relation with Test category match
     * @return BelongsTo
     */
    public function test_category()
    {
        return $this->belongsTo(TestCategoryMatch::class);
    }

    /** Relation with Test type category match
     * @return BelongsTo
     */
    public function test_type_category()
    {
        return $this->belongsTo(TestTypeCategoryMatch::class);
    }
    
    /** Relation with type modality match
     * @return BelongsTo
     */
    public function modality()
    {
        return $this->belongsTo(TypeModalityMatch::class);
    }
    
    /** Relation with competition
     * @return BelongsTo
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
    
    /** Relation with rival match
     * @return hasMany
     */
    public function rivals()
    {
        return $this->hasMany(CompetitionMatchRival::class);
    }

    /**
     * Get the related weather model
     * @return object
     */
    public function weather()
    {
        return $this->belongsTo(Weather::class)->withTranslation(app()->getLocale());
    }

    /**
     * Get the related weather model
     * @return object
     */
    public function referee()
    {
        return $this->belongsTo(Referee::class);
    }

    /**
     * Relation with CompetitionRivalTeam
     * @return BelongsTo
     */
    public function competitionRivalTeam()
    {
        return $this->belongsTo(CompetitionRivalTeam::class);
    }

    /**
     * Relation with CompetitionMatchRival
     * @return BelongsTo
     */
    public function competitionMatchRival()
    {
        return $this->hasMany(CompetitionMatchRival::class);
    }

    /**
     * Returns the related lineup to the match
     * @return object
     */
    public function lineup()
    {
        return $this->hasOne(CompetitionMatchLineup::class)->with('typeLineup');
    }

    /**
     */
    public function players()
    {
        return $this->hasMany(CompetitionMatchPlayer::class)->with(['player', 'perceptEffort']);
    }

    // --------- Calculated Attributes

    /**
     * Competition's name
     * @return string|null
     */
    public function getCompetitionNameAttribute()
    {
        return $this->competition ? $this->competition->name : null;
    }

    /**
     * Competition's image
     * @return string|null
     */
    public function getCompetitionUrlImageAttribute()
    {
        return $this->competition && $this->competition->image ? $this->competition->image->url : null;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CompetitionMatchFactory::new();
    }
}
