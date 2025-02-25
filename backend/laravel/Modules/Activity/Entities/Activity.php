<?php

namespace Modules\Activity\Entities;

use Illuminate\Database\Eloquent\Model;

// Extenal Models
use Modules\User\Entities\User;
use Modules\Activity\Entities\ActivityType;

class Activity extends Model
{
    /**
     * Disabled timestamps for not inserting data
     *
     * @var Boolean
     */
    public $timestamps = false;

    /**
     * Name of the model table
     *
     * @var String
     */
    protected $table = 'activities';

    /**
     * List of fillable properties of the model
     *
     * @var Array
     */
    protected $fillable = [
        'user_id',
        'activity_type_id',
        'entity_id',
        'entity_type',
        'secondary_entity_id',
        'secondary_entity_type',
        'third_entity',
        'type'
    ];

    /**
     * List of casting types properties of the model
     *
     * @var Array
     */
    protected $casts = [
        'third_entity' => 'array',
    ];

    /**
     * Get all of the models that own activities.
     *
     * @return object
     */
    public function entity()
    {
        return $this->morphTo();
    }

    /**
     * Retrieves the secondary related entity to the activity
     *
     * @return object
     */
    public function secondaryEntity()
    {
        return $this->morphTo();
    }

    /**
     * Returns the related user
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsTo(User::class)
            ->select('id', 'full_name', 'email', 'image_id')
            ->with('image');
    }

    /**
     * Return the activity type
     *
     * @return object
     */
    public function activity_type()
    {
        return $this->belongsTo(ActivityType::class)
            ->withTranslation(app()->getLocale()
        );
    }
}
