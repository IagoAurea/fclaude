<?php

namespace Modules\Psychology\Entities;

use Modules\Player\Entities\Player;
use Modules\Staff\Entities\StaffUser;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PsychologyReport extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'psychology_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'psychology_specialist_id',
        'date',
        'staff_id',
        'staff_name',
        'cause',
        'anamnesis',
        'presumptive_diagnosis',
        'note',
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
        'team_sport_name',
        'team_sport_code',
        'player_position',
        'player_demarcation',
        'psychology_specialist_name',
        'team_staff_name'
    ];

    protected $hidden = [
        'player',
        'psychologySpecialist',
        'staff'
    ];

    /**
     * Relation with player
     * @return BelongsTo
     */
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    /**
     * Relation with PsychologySpecialist
     * @return BelongsTo
     */
    public function psychologySpecialist()
    {
        return $this->belongsTo(PsychologySpecialist::class);
    }

    /**
     * Return staff related to the entity
     *
     * @return array
     */
    public function staff()
    {
        return $this->belongsTo(
            StaffUser::class
        )->with([
            'user', 'image', 'studyLevel', 'jobArea', 'positionStaff',
        ]);
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
        return $this->player && $this->player->team->modality ? $this->player->team->modality->name : null;
    }

    /**
     * Team's image
     * @return string|null
     */
    public function getTeamImageAttribute()
    {
        return $this->player && $this->player->team->image ? $this->player->team->image->url : null;
    }

    /**
     * Team's color
     * @return string|null
     */
    public function getTeamColorAttribute()
    {
        return $this->player && $this->player->team ? $this->player->team->color : null;
    }

    /**
     * Team's sport code
     * @return string|null
     */
    public function getTeamSportCodeAttribute()
    {
        return $this->player && $this->player->team->sport ? $this->player->team->sport->code : null;
    }

    /**
     * Team's sport name
     * @return string|null
     */
    public function getTeamSportNameAttribute()
    {
        return $this->player && $this->player->team->sport ? $this->player->team->sport->name : null;
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
     * PsychologySpecialist's name
     * @return string|null
     */
    public function getPsychologySpecialistNameAttribute()
    {
        return $this->psychologySpecialist ? $this->psychologySpecialist->name : null;
    }

    /**
     * Staff's name
     * @return string|null
     */
    public function getTeamStaffNameAttribute()
    {
        return $this->staff ? $this->staff->full_name : null;
    }
}
