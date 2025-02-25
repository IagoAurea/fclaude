<?php

namespace Modules\Nutrition\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Club\Entities\Staff;
use Modules\Player\Entities\Player;
use Modules\Staff\Entities\StaffUser;
use Modules\Team\Entities\Team;
use Modules\Team\Entities\TeamStaff;


/**
 * @OA\Schema(
 *      title="NutritionalSheet",
 *      description="NutritionalSheet model",
 *      @OA\Xml( name="NutritionalSheet"),
 *      @OA\Property( title="Take Supplements", property="take_supplements", description="if take supplements", format="boolean", example="true" ),
 *      @OA\Property( title="Take Diet", property="take_diets", description="if take diets", format="boolean", example="true" ),
 *      @OA\Property( title="Activity Factor", property="activity_factor", description="calculate activity factor", format="decimal", example="15.5" ) ,
 *      @OA\Property( title="Other Supplement", property="other_supplement", description="name", format="string", example="Supplement New" ) ,
 *      @OA\Property( title="Other Diet", property="other_diet", description="name", format="string", example="Diet New" ), 
 *      @OA\Property( title="Total Energy Expendidure", property="total_energy_expenditure", description="calculate", format="decimal", example="20.3" ) ,
 *      @OA\Property( title="Player", property="player_id", description="Player associate", format="integer", example="1" ),
 *      @OA\Property( title="Team", property="team_id", description="Team associate", format="integer", example="1" ) 
 * * )
 */
class NutritionalSheet extends Model
{
    use SoftDeletes;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nutritional_sheets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'take_supplements',
        'take_diets',
        'activity_factor',
        'other_supplement',
        'other_diet',
        'total_energy_expenditure',
        'player_id',
        'team_id',
        'user_id'
    ];

    /**
     * additional values
     * @var string[]
     */
    protected $appends = [
        'player_height',
        'player_weight',
        'player_age',
        'player_gender',
        'player_name',
        'player_image',
        'player_team',
        'player_category',
        'team_modality',
        'team_image',
        'team_color',
        'team_sport_code',
        'team_sport_name',
        'player_position',
        'player_demarcation',
        'staff_name',
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
     * Returns a list of supplements objects related to the nutritional sheet
     *
     * @return Array
     */
    public function supplements()
    {
        return $this->belongsToMany(
            Supplement::class,
            'nutritional_sheet_supplement'
        )->withTimestamps();
    }

    /**
     * Returns a list of diets objects related to the nutritional sheet
     *
     * @return Array
     */
    public function diets()
    {
        return $this->belongsToMany(
            Diet::class,
            'nutritional_sheet_diet'
        )->withTimestamps();
    }

    /**
     * Returns the Athlete Activity object related to the  nutritional sheet
     *
     * @return Array
     */
    public function athleteActivity()
    {
        return $this->belongsTo(AthleteActivity::class);
    }

    /**
     * Returns the Player object related to the  nutritional sheet
     *
     * @return Array
     */
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    /**
     * Returns the Team object related to the  nutritional sheet
     *
     * @return Array
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * Player's weight
     * @return string|null
     */
    public function getPlayerWeightAttribute()
    {
        return $this->player ? $this->player->weight : null;
    }

    /**
     * Player's height
     * @return string|null
     */
    public function getPlayerHeightAttribute()
    {
        return $this->player ? $this->player->height : null;
    }

    /**
     * Player's age
     * @return string|null
     */
    public function getPlayerAgeAttribute()
    {
        return $this->player ? $this->player->age : null;
    }

    /**
     * Player's gender
     * @return string|null
     */
    public function getPlayerGenderAttribute()
    {
        return $this->player ? $this->player->gender : null;
    }

    /**
     * Player's name
     * @return string|null
     */
    public function getPlayerNameAttribute()
    {
        return $this->player ? $this->player->full_name : null;
    }

    /**
     * Player's image
     * @return string|null
     */
    public function getPlayerImageAttribute()
    {
        return $this->player && $this->player->image ? $this->player->image->url : null;
    }

    /**
     * Player's team
     * @return string|null
     */
    public function getPlayerTeamAttribute()
    {
        return $this->player && $this->player->team ? $this->player->team->name : null;
    }

    /**
     * Player's category
     * @return string|null
     */
    public function getPlayerCategoryAttribute()
    {
        return $this->player && $this->player->team ? $this->player->team->category : null;
    }

    /**
     * Team's modality
     * @return string|null
     */
    public function getTeamModalityAttribute()
    {
        return $this->team && $this->team->modality ? $this->team->modality->name : null;
    }

    /**
     * Team's image
     * @return string|null
     */
    public function getTeamImageAttribute()
    {
        return $this->team && $this->team->image ? $this->team->image->url : null;
    }

    /**
     * Team's color
     * @return string|null
     */
    public function getTeamColorAttribute()
    {
        return $this->team && $this->team->color ? $this->team->color : null;
    }

    /**
     * Team's sport code
     * @return string|null
     */
    public function getTeamSportCodeAttribute()
    {
        return $this->team && $this->team->sport ? $this->team->sport->code : null;
    }

    /**
     * Team's sport name
     * @return string|null
     */
    public function getTeamSportNameAttribute()
    {
        return $this->team && $this->team->sport ? $this->team->sport->name : null;
    }

    /**
     * Player's position
     * @return string|null
     */
    public function getPlayerPositionAttribute()
    {
        return $this->player ? $this->player->shirt_number : null;
    }

    /**
     * Player's demarcation
     * @return string|null
     */
    public function getPlayerDemarcationAttribute()
    {
        return $this->player && $this->player->position ? $this->player->position->name : null;
    }

    /**
     * Staff's name
     * @return string|null
     */
    public function getStaffNameAttribute()
    {
        return 'Administrador del sistema';
    }
}
