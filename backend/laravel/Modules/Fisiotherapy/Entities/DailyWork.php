<?php

namespace Modules\Fisiotherapy\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Fisiotherapy\Entities\File;
 
class DailyWork extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_work';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'minutes_duration',
        'sensations',
        'exploration',
        'tests',
        'observations',
        'work_date',
        'treatments',
        'file_id',
    ];

    /**
     * The attributes that are hidden for resulting queries.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'treatments' => 'array'
    ];


    /**
     * Retrieves the file related to the work
     */
    public function file()
    {
        return $this->belongsTo(File::class)->select('id', 'title', 'start_date');
    }
}
