<?php

namespace Modules\Evaluation\Repositories;

use Modules\Evaluation\Repositories\Interfaces\IndicatorRepositoryInterface;
use Modules\Evaluation\Entities\Indicator;
use App\Services\ModelRepository;

class IndicatorRepository extends ModelRepository implements IndicatorRepositoryInterface
{
    /**
     * Model
     * @var Indicator $model
     */
    protected $model;

    /**
     * Instances a new repository class
     * 
     * @param Indicator $model
     */
    public function __construct(Indicator $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function assignCompetencesToIndicator($indicator_id, $competences)
    {
        $indicator = $this->find($indicator_id);

        if (!$indicator) {
            return false;
        }

        return $indicator->competences()->sync($competences);
    }

    public function withoutRubrics()
    {
        return $this->model->doesntHave('rubrics')->get();
    }
}
