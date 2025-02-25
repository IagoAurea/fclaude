<?php

namespace Modules\Health\Repositories;

use Modules\Health\Repositories\Interfaces\PhysicalProblemRepositoryInterface;
use Modules\Health\Entities\PhysicalProblem;
use App\Services\ModelRepository;

class PhysicalProblemRepository extends ModelRepository implements PhysicalProblemRepositoryInterface
{
     /**
     * @var string
    */
    protected $table = 'physical_problems';

    /**
     * @var string
    */
    protected $tableTranslations = 'physical_problem_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'physical_problem_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(PhysicalProblem $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return diseases translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}