<?php

namespace Modules\Family\Repositories;

use Modules\Family\Repositories\Interfaces\FamilyEntityMemberRepositoryInterface;
use Modules\Family\Entities\FamilyEntityMember;
use App\Services\ModelRepository;

class FamilyEntityMemberRepository extends ModelRepository implements FamilyEntityMemberRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(FamilyEntityMember $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
