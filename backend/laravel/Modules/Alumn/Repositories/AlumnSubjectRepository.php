<?php

namespace Modules\Alumn\Repositories;

use App\Services\ModelRepository;
use Modules\Alumn\Entities\AlumnSubject;
use Modules\Alumn\Repositories\Interfaces\AlumnSubjectRepositoryInterface;

class AlumnSubjectRepository extends ModelRepository implements AlumnSubjectRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(AlumnSubject $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }
}
