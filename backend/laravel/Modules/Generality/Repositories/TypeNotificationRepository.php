<?php

namespace Modules\Generality\Repositories;

use App\Services\ModelRepository;
use Modules\Generality\Entities\TypeNotification;
use Modules\Generality\Repositories\Interfaces\TypeNotificationRepositoryInterface;

class TypeNotificationRepository extends ModelRepository implements TypeNotificationRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(TypeNotification $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}