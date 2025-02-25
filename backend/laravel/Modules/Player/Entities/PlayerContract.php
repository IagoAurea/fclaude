<?php

namespace Modules\Player\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Player\Entities\Player;
use Modules\Generality\Entities\Resource;
use Carbon\Carbon;

class PlayerContract extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'player_contracts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'title',
        'year_duration',
        'contract_creation',
        'image_id',
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
     * Calculated valeus related to the model
     * 
     * @var array
     */
    protected $appends = [
        'contract_end',
        'remaining_days'
    ];

    /**
     * Calcualtes the end date of the contract
     * 
     * @return datetime
     */
    public function getContractEndAttribute()
    {
        return Carbon::parse(
            $this->contract_creation
        )->addYears(
            $this->year_duration
        )->format(
            'Y-m-d H:i:s'
        );
    }

    /**
     * Calcualtes the remaining days of the contract
     * 
     * @return datetime
     */
    public function getRemainingDaysAttribute()
    {
        return Carbon::parse($this->contract_end) > Carbon::now() ? 
            Carbon::parse($this->contract_end)->diffInDays(Carbon::now()) : 0;
    }

    /**
     * Get the player related to this family information
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Get the image of the player contract.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class)->select(
            'id', 'url', 'mime_type', 'size'
        );
    }
}
