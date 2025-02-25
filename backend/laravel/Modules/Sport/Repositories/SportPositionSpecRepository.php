<?php

namespace Modules\Sport\Repositories;

use Modules\Sport\Repositories\Interfaces\SportPositionSpecRepositoryInterface;
use Modules\Sport\Entities\SportPositionSpec;
use App\Services\ModelRepository;

class SportPositionSpecRepository extends ModelRepository implements SportPositionSpecRepositoryInterface
{
    /** 
     * @var object
     */
    protected $model;
    
    /**
     * Instance a new repository
     */
    public function __construct(SportPositionSpec $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * 
     */
    public function findAllTranslated($sportPositionId)
    {
        return $this->model->where(
            'sport_position_id', $sportPositionId
        )->withTranslation(
            app()->getLocale()
        )->get();
    }
}