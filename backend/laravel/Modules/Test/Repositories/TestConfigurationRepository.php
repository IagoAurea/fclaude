<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\TestConfiguration;
use Modules\Test\Repositories\Interfaces\TestConfigurationRepositoryInterface;


class TestConfigurationRepository extends ModelRepository implements TestConfigurationRepositoryInterface
{
    
    /**
     * @var string
    */
    protected $table = 'test_configurations';

    /**
     * @var object
    */
    protected $model;

   

    public function __construct(
        TestConfiguration $model
    )
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

}