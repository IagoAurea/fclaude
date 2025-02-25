<?php

namespace Modules\Sport\Repositories;

use Modules\Sport\Repositories\Interfaces\SportPositionRepositoryInterface;
use Modules\Sport\Entities\SportPosition;
use App\Services\ModelRepository;

class SportPositionRepository extends ModelRepository implements SportPositionRepositoryInterface
{
    /** 
     * @var object
     */
    protected $model;

    /**
     * Instance a new repository
     */
    public function __construct(SportPosition $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findAllTranslated($sportId)
    {
        return $this->model->where(
            'sport_id', $sportId
        )->withTranslation(
            app()->getLocale()
        )->get();
    }
}