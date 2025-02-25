<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\QuestionTest;
use Modules\Test\Repositories\Interfaces\QuestionTestRepositoryInterface;

class QuestionTestRepository extends ModelRepository implements QuestionTestRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(QuestionTest $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}