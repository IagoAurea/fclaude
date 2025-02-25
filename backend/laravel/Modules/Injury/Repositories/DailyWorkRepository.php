<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\DailyWork;
use Modules\Injury\Repositories\Interfaces\DailyWorkRepositoryInterface;

class DailyWorkRepository extends ModelRepository implements DailyWorkRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'daily_works';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        DailyWork $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findAllByRdf($rdf_id)
    {
         $dailyWorks = $this->model
        ->where('injury_rfd_id',$rdf_id)
        ->get(); 
    
         return $dailyWorks;
    }
}