<?php

namespace Modules\InjuryPrevention\Repositories;

use App\Services\ModelRepository;
use Modules\InjuryPrevention\Entities\EvaluationQuestion;
use Modules\InjuryPrevention\Repositories\Interfaces\EvaluationQuestionRepositoryInterface;

class EvaluationQuestionRepository extends ModelRepository implements EvaluationQuestionRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'evaluation_questions';

    /**
     * @var string
    */
    protected $tableTranslations = 'evaluation_question_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'evaluation_question_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(EvaluationQuestion $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return preventive_program_types translations
     *
     * @return array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}