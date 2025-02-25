<?php

namespace Modules\Package\Repositories;

use Modules\Package\Repositories\Interfaces\SubpackageRepositoryInterface;
use Modules\Package\Entities\Subpackage;
use App\Services\ModelRepository;

class SubpackageRepository extends ModelRepository implements SubpackageRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(Subpackage $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}