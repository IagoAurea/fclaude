<?php

namespace Modules\Package\Repositories;

use Modules\Package\Repositories\Interfaces\AttributePackRepositoryInterface;
use Modules\Package\Entities\AttributePack;
use App\Services\ModelRepository;

class AttributePackRepository extends ModelRepository implements AttributePackRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(AttributePack $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}