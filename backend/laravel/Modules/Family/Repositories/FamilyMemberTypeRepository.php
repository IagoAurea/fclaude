<?php

namespace Modules\Family\Repositories;

use App\Services\ModelRepository;
use Modules\Family\Entities\FamilyMemberType;
use Modules\Family\Repositories\Interfaces\FamilyMemberTypeRepositoryInterface;

class FamilyMemberTypeRepository extends ModelRepository implements FamilyMemberTypeRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(FamilyMemberType $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
