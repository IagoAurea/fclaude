<?php

namespace Modules\Fisiotherapy\Entities;

use Carbon\Carbon;
use Modules\Player\Entities\Player;
use Modules\Staff\Entities\StaffUser;
use Illuminate\Database\Eloquent\Model;
use Modules\Fisiotherapy\Entities\DailyWork;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'specialty',
        'anamnesis',
        'has_medication',
        'medication',
        'medication_objective',
        'observation',
        'start_date',
        'discharge_date',
        'player_id',
        'team_staff_id',
        'injury_id',
        'user_id'
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'day_difference',
        'hour_difference',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'discharge_date' => 'date',
    ];

    /**
     * The attributes that are hidden for resulting queries.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the difference in days between both starting and
     * ending date
     *
     * @return Int
     */
    public function getDayDifferenceAttribute()
    {
        $start = new Carbon($this->start_date);
        $end = !$this->discharge_date ? Carbon::now() : new Carbon($this->discharge_date);

        return $start->diffInDays($end);
    }

    /**
     * Get the difference in time values between both
     * starting and ending date
     *
     * @return String
     */
    public function getHourDifferenceAttribute()
    {
        $start = new Carbon($this->start_date);
        $end = !$this->discharge_date ? Carbon::now() : new Carbon($this->discharge_date);

        return $start->diffInHours($end);
    }

    /**
     * Retrieves informations about player related to the file
     *
     * @return Array
     */
    public function player()
    {
        return $this->belongsTo(Player::class)->select('id', 'full_name', 'alias','team_id');
    }

    /**
     * Retrieves informations about staff related to the file
     *
     * @return Array
     */
    public function teamStaff()
    {
        return $this->belongsTo(StaffUser::class)->select('id', 'full_name', 'jobs_area_id');
    }

    /**
     * Retrieves all daily work related to the file
     *
     * @return Array
     */
    public function dailyWorks()
    {
        return $this->hasMany(DailyWork::class);
    }
}
