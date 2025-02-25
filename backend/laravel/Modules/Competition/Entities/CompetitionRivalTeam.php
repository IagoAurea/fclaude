<?php


namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Competition\Database\Factories\CompetitionRivalTeamFactory;
use Modules\Generality\Entities\Resource;

class CompetitionRivalTeam extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'competition_rival_teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'competition_id',
        'rival_team',
        'image_id',
    ];

    /**
     * Additional fields
     * @var string[]
     */
    protected $appends = [
        "url_image"
    ];

    /**
     * Hiding fields
     * @var string[]
     */
    protected $hidden = [
        "image"
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Competition relation
     * @return BelongsTo
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    /**
     * Relation with resources
     * @return BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Resource::class, "image_id");
    }

    /**
     * Image's url
     * @return string|null
     */
    public function getUrlImageAttribute()
    {
        return $this->image ? $this->image->url : null;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CompetitionRivalTeamFactory::new();
    }
}
