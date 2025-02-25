<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\PhaseDetail;
use Modules\Injury\Repositories\Interfaces\PhaseDetailRepositoryInterface;

class PhaseDetailRepository extends ModelRepository implements PhaseDetailRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'phase_details';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        PhaseDetail $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

}