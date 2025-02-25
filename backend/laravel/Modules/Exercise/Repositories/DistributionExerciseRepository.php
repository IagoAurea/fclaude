<?php

namespace Modules\Exercise\Repositories;

use Modules\Exercise\Repositories\Interfaces\DistributionExerciseRepositoryInterface;
use Modules\Exercise\Entities\DistributionExercise;
use App\Services\ModelRepository;

class DistributionExerciseRepository extends ModelRepository implements DistributionExerciseRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'distribution_exercises';

    /**
     * @var string
     */
    protected $tableTranslations = 'distribution_exercise_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'distribution_exercise_id';

    /**
     * @var object
     */
    protected $model;

    public function __construct(DistributionExercise $model)
    {
        $this->model = $model;
        parent::__construct($this->model);
    }

    /**
     *  Return translations
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}
