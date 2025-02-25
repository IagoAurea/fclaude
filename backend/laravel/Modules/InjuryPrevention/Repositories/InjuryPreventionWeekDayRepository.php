<?php

namespace Modules\InjuryPrevention\Repositories;

use Modules\InjuryPrevention\Repositories\Interfaces\InjuryPreventionWeekDayRepositoryInterface;
use Modules\InjuryPrevention\Entities\InjuryPreventionWeekDay;
use App\Services\ModelRepository;

class InjuryPreventionWeekDayRepository extends ModelRepository implements InjuryPreventionWeekDayRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Create a new repository instance
     */
    public function __construct(InjuryPreventionWeekDay $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }
}
