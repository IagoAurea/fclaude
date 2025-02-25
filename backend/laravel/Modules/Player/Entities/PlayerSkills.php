<?php

namespace Modules\Player\Entities;

use Modules\Player\Entities\Player;
use Modules\Player\Entities\Skills;
use Illuminate\Database\Eloquent\Model;
use Modules\Player\Entities\Punctuation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="PlayerSkills",
 *      description="PlayerSkills model",
 *      @OA\Xml( name="PlayerSkills"),
 *      @OA\Property( title="Player", property="player_id", description="player associate", format="integer", example="1" ),
 *      @OA\Property( title="Skill", property="skills_id", description="skill associate", format="integer", example="1" ),
 *      @OA\Property( title="Punctuation", property="punctuation_id", description="punctuation associate", format="integer", example="1" )
 * )
 */
class PlayerSkills extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'player_skills';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'skills_id',
        'punctuation_id'
    ];

    /**
     * The attributes that are hidden for resulting queries.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to datetime types.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Gets the related player information
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Gets the related skill information
     */
    public function skills()
    {
        return $this->belongsTo(Skills::class);
    }

    /**
     * Gets the related punctuation information
     */
    public function punctuation()
    {
        return $this->belongsTo(Punctuation::class);
    }

}
