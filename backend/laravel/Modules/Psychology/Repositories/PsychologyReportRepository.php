<?php

namespace Modules\Psychology\Repositories;

use App\Services\ModelRepository;
use Modules\Psychology\Entities\PsychologyReport;
use Modules\Psychology\Repositories\Interfaces\PsychologyReportRepositoryInterface;

class PsychologyReportRepository extends ModelRepository implements PsychologyReportRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    public function __construct(PsychologyReport $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }


}
