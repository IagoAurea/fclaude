<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\SplashRepositoryInterface;
use Modules\Generality\Entities\Splash;
use App\Services\ModelRepository;

class SplashRepository extends ModelRepository implements SplashRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    public function __construct(Splash $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}