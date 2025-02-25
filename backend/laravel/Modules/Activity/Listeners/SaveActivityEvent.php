<?php

namespace Modules\Activity\Listeners;

use Modules\Activity\Events\ActivityEvent;
use Modules\Activity\Repositories\Interfaces\ActivityRepositoryInterface;
use Modules\Activity\Repositories\Interfaces\ActivityTypeRepositoryInterface;
use Modules\Activity\Repositories\Interfaces\EntityActivityRepositoryInterface;

class SaveActivityEvent
{
    /**
     * @var object
     */
    protected $activityRepository;

    /**
     * @var $resourceRepository
     */
    protected $activityTypeRepository;

    /**
     * @var $resourceRepository
     */
    protected $activityEntityRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        ActivityRepositoryInterface $activityRepository,
        ActivityTypeRepositoryInterface $activityTypeRepository,
        EntityActivityRepositoryInterface $activityEntityRepository
    ) {
        $this->activityRepository = $activityRepository;
        $this->activityTypeRepository = $activityTypeRepository;
        $this->activityEntityRepository = $activityEntityRepository;
    }

    /**
     * Handle the event.
     *
     * @param ActivityEvent $event
     * @return void
     */
    public function handle(ActivityEvent $event)
    {
        $activityType = $this->activityTypeRepository->findOneBy([
            'code'  =>  $event->activityName
        ]);

        $secondaryEntityId = $event->secondaryEntity ? $event->secondaryEntity->id : null;
        $secondaryEntityClass = $event->secondaryEntity ? get_class($event->secondaryEntity) : null;

        $this->activityRepository->create([
            'user_id' => $event->user->id,
            'activity_type_id' => $activityType->id,
            'entity_id' => $event->entity->id,
            'entity_type' => get_class($event->entity),
            'secondary_entity_id' => $secondaryEntityId,
            'secondary_entity_type' => $secondaryEntityClass,
            'third_entity' => $event->thirdEntity,
            'type' => $event->type
        ]);
    }
}
