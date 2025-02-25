<?php

namespace Modules\Exercise\Repositories;

use Modules\Exercise\Repositories\Interfaces\ExerciseContentBlockRepositoryInterface;
use Modules\Exercise\Entities\ExerciseContentBlock;
use App\Services\ModelRepository;

class ExerciseContentBlockRepository extends ModelRepository implements ExerciseContentBlockRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'exercise_content_blocks';

    /**
     * @var string
     */
    protected $tableTranslations = 'exercise_content_block_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'exercise_content_block_id';

    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(ExerciseContentBlock $model)
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
