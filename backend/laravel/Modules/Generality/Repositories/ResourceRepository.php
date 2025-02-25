<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Generality\Entities\Resource;
use App\Services\ModelRepository;

class ResourceRepository extends ModelRepository implements ResourceRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(Resource $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}