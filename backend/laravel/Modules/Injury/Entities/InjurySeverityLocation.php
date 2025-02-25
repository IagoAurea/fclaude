<?php

namespace Modules\Injury\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Entities\Resource;

class InjurySeverityLocation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'injury_severity_location';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'severity_id',
        'location_id',
        'image_id',
        'affected_side_id'
    ];

    /**
     * Allways show this relationships
     * 
     * @var array
     */
    protected $with = [
        "image"
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

     /**
     * Get the team that owns the image.
     */
    public function image()
    {
        return $this->belongsTo(Resource::class);
    }
}
