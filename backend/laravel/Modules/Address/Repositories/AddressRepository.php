<?php

namespace Modules\Address\Repositories;

use App\Services\ModelRepository;
use Modules\Address\Entities\Address;
use Modules\Address\Repositories\Interfaces\AddressRepositoryInterface;

class AddressRepository extends ModelRepository implements AddressRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(Address $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
