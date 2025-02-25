<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\QuestionResponse;
use Modules\Test\Repositories\Interfaces\QuestionResponseRepositoryInterface;

class QuestionResponseRepository extends ModelRepository implements QuestionResponseRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(QuestionResponse $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}