<?php

namespace Modules\EffortRecovery\Repositories;

use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerTypeRepositoryInterface;
use Modules\EffortRecovery\Entities\WellnessQuestionnaireAnswerType;
use App\Services\ModelRepository;

class WellnessQuestionnaireAnswerTypeRepository extends ModelRepository
    implements WellnessQuestionnaireAnswerTypeRepositoryInterface
{
     /**
     * @var object
    */
    protected $model;

    /**
     * @var String
     */
    protected $table = 'wellness_questionnaire_answer_types';

    /**
     * @var String
     */
    protected $tableTranslations = 'wellness_questionnaire_answer_type_translations';

    /**
     * @var String
     */
    protected $fieldAssociate = 'wellness_questionnaire_answer_type_id';

    /**
     * Create a new repository instance
     */
    public function __construct(WellnessQuestionnaireAnswerType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Return all effort recovery strategies with translations
     *
     * @return Array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * Return all the answer types with all their related items
     * 
     * @return Array
     */
    public function findAllRelated()
    {
        return $this->model->with('items')->get();
    }
}
