<?php

namespace Modules\Generality\Repositories;

use App\Services\ModelRepository;
use Modules\Generality\Entities\Notification;
use Modules\Generality\Repositories\Interfaces\NotificationRepositoryInterface;

class NotificationRepository extends ModelRepository implements NotificationRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(Notification $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}