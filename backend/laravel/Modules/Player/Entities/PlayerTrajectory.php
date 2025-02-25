<?php

namespace Modules\Player\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Player\Entities\Player;
use Modules\Player\Entities\ClubArrivalType;
use Modules\Generality\Entities\Resource;
use Carbon\Carbon;

class PlayerTrajectory extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'player_trajectories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category',
        'title',
        'player_id',
        'image_id',
        'club_arrival_type_id',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'duration',
    ];

    /**
     * The attributes that might be hidden
     * 
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Attributes that are date parsed
     */
    protected $dates = [
        'start_date', 'end_date'
    ];

    /**
     * Get the calculated age attribute
     * 
     * @return Array
     */
    public function getDurationAttribute()
    {
        $start = Carbon::parse($this->start_date);
        $end = $this->end_date ?? Carbon::now();

        $difference = $start->diffInYears($end);
        $timelapse = 'years';

        if ($difference < 1) {
            $monthDiff = $start->diffInMonths($end);
            if ($monthDiff < 1) {
                $difference =  $start->diffInDays($end);
                $timelapse = 'days';
            } else {
                $difference = $monthDiff;
                $timelapse = 'months';
            }
        }

        return [
            'difference' => $difference,
            'timelapse' => $timelapse,
        ];
    }

    /**
     * Get the related disease object to the trajectory
     * 
     * @return Array|Object
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * Returns the related image resource object
     * 
     * @return Object
     */
    public function image () {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Returns the related club arrival type
     * 
     * @return Object
     */
    public function clubArrivalType () {
        return $this->belongsTo(ClubArrivalType::class);
    }
}
