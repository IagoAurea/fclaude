<?php

namespace Modules\Package\Repositories;

use App\Services\ModelRepository;
use Modules\Package\Entities\SubpackageSport;
use Modules\Package\Repositories\Interfaces\SubpackageSportRepositoryInterface;

class SubpackageSportRepository extends ModelRepository implements SubpackageSportRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(SubpackageSport $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}