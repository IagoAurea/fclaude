<?php

namespace Modules\Activity\Events;

use Illuminate\Queue\SerializesModels;

class ActivityEvent
{
    use SerializesModels;

    /**
     * References an user object to be referenced to the activity
     *
     * @var User $user
     */
    public $user;

    /**
     * References a entity object to be referenced to the activity
     *
     * @var Eloquent $entity
     */
    public $entity;

    /**
     * References the activity name to be stored and search for it on the database
     *
     * @var String $activityName
     */
    public $activityName;

    /**
     * References a secondary entity to be referenced to the activity
     *
     * @var Eloquent $entity
     */
    public $secondaryEntity;

    /**
     * References a secondary entity to be referenced to the activity
     *
     * @var Eloquent $entity
     */
    public $thirdEntity;

    /**
     * References the list of parent entities that has multiple activites related
     *
     * @var Array $activityEntities
     */
    public $activityEntities;
    
    /**
     * References the profile
     *
     * @var String $type
     */
    public $type;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        $user,
        $entity,
        $activityName,
        $secondaryEntity = null,
        $thirdEntity = null,
        $activityEntities = [],
        $type = 'sport'
    ) {
        $this->user = $user;
        $this->entity = $entity;
        $this->activityName = $activityName;
        $this->secondaryEntity = $secondaryEntity;
        $this->thirdEntity = $thirdEntity;
        $this->activityEntities = $activityEntities;
        $this->type = $type;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
