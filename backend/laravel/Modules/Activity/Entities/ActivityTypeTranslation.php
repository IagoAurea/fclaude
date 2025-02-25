<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;

// Entities
use Modules\Activity\Entities\ActivityType;

class ActivityTypeTranslation extends Model
{
    /**
     * Disabled timestamps for not inserting data
     *
     * @var String
     */
    public $timestamps = false;

    /**
     * Name of the table
     *
     * @var String $table
     */
    protected $table = 'activity_type_translations';

    /**
     * Set of fillable properties of model
     *
     * @var Array $fillable
     */
    protected $fillable = [
        'name',
    ];
}
