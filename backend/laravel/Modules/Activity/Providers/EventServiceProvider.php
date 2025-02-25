<?php

namespace Modules\Activity\Providers;

use Modules\Activity\Events\ActivityEvent;
use Modules\Activity\Listeners\SaveActivityEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ActivityEvent::class => [
            SaveActivityEvent::class
        ],
    ];
}
