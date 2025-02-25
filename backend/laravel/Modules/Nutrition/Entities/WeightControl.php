<?php

namespace Modules\Nutrition\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      title="WeightControl",
 *      description="WeightControl model",
 *      @OA\Xml( name="WeightControl"),
 *      @OA\Property( title="Weight", property="weight", description="weight medition", format="decimal", example="80.5" ),
 *      @OA\Property( title="Player", property="player_id", description="Player associate", format="integer", example="1" ),
 *      @OA\Property( title="Team", property="team_id", description="Team associate", format="integer", example="1" ) 
 * * )
 */
class WeightControl extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'weight',
        'player_id',
        'team_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'deleted_at',
        'player_id'
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
     * Returns the Player object related to the  weight control
     * 
     * @return Array
     */
    public function Player () {
        return $this->belongsTo(Player::class);
    }



}
