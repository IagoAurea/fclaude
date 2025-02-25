<?php

namespace Modules\Exercise\Events;

use Modules\Exercise\Entities\Exercise;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Load3DExerciseEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Sets the code of the exercise in our event.
     * 
     */
    public $exercise;
    /**
     * Sets the status event.
     * 
     * @var string $status
     */
    public $status;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Exercise $exercise, string $status = 'finished')
    {
        $this->exercise = $exercise;
        $this->status = $status;
    }

    /**
     * 
     */
    public function broadcastWith()
    {
        return [
            'exercise_id' => $this->exercise->id,
            'exercise_code' => $this->exercise->code,
            'status' => $this->status
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('exercise.3d.' . $this->exercise->code);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'exercise-3d';
    }
}
