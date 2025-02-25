<?php

namespace Modules\Package\Repositories;

use Modules\Package\Repositories\Interfaces\PackagePriceRepositoryInterface;
use Modules\Package\Entities\PackagePrice;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;

class PackagePriceRepository extends ModelRepository implements PackagePriceRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    public function __construct(PackagePrice $model)
    {
        $this->model = $model;

        parent::__construct($this->model, ['subpackage']);
    }

}