<?php

namespace Modules\Health\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Health\Entities\Disease;
use Carbon\Carbon;

class Surgery extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'surgeries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'entity_id',
        'entity_type',
        'disease_id',
        'surgery_date',
    ];

    /**
     * The attributes that are calculated types.
     *
     * @var array
     */
    protected $appends = [
        'time_passed',
    ];

    /**
     * The attributes that must not show from querying.
     *
     * @var array
     */
    protected $hidden = [
        'entity_type',
        'entity_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the calculated age attribute
     */
    public function getTimePassedAttribute()
    {
        $now = Carbon::now();
        $surgery_date = Carbon::parse($this->surgery_date);
        $years_diff = $surgery_date->diffInYears($now);

        if ($years_diff > 0) {
            return [
                'time_lapse' => 'years',
                'time_value' => $years_diff
            ];
        }

        return [
            'time_lapse' => 'months',
            'time_value' => $surgery_date->diffInMonths($now)
        ];
    }

    /**
     * Get the related disease object to the surgery
     * 
     * @return Array|Object
     */
    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

    /**
     * Get the related entity
     * 
     * @return Array|Object
     */
    public function entity()
    {
        return $this->morphTo();
    }
}
