<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;

use Modules\Activity\Entities\Activity;

class EntityActivity extends Model
{
    /**
     * Disabled timestamps for not inserting data
     *
     * @var String
     */
    public $timestamps = false;

    /**
     * Name of the model table
     *
     * @var String
     */
    protected $table = 'entity_activities';

    /**
     * List of fillable properties of the model
     *
     * @var Array
     */
    protected $fillable = [
        'activity_id',
        'entity_type',
        'entity_id'
    ];
    
    /**
     * Get all of the models that own activities.
     *
     * @return array
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Get the related activity
     *
     * @return array
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class)
            ->with('user')
            ->with('activity_type')
            ->with('entity');
    }
}
