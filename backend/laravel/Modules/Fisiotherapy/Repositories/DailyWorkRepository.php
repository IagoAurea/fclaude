<?php

namespace Modules\Fisiotherapy\Repositories;

use Modules\Fisiotherapy\Repositories\Interfaces\DailyWorkRepositoryInterface;
use Modules\Fisiotherapy\Entities\DailyWork;
use App\Services\ModelRepository;

class DailyWorkRepository extends ModelRepository implements DailyWorkRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(DailyWork $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
