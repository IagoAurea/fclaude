<?php

namespace Modules\Family\Repositories;

use Modules\Family\Repositories\Interfaces\FamilyMemberRepositoryInterface;
use Modules\Family\Entities\FamilyMember;
use App\Services\ModelRepository;

class FamilyMemberRepository extends ModelRepository implements FamilyMemberRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;
    
    public function __construct(FamilyMember $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
