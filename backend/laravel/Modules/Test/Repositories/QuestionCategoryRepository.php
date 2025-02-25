<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\QuestionCategory;
use Modules\Test\Repositories\Interfaces\QuestionCategoryRepositoryInterface;

class QuestionCategoryRepository extends ModelRepository implements QuestionCategoryRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'question_categories';

    /**
     * @var string
    */
    protected $tableTranslations = 'question_category_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'question_category_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        QuestionCategory $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return QuestionCategory type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

}