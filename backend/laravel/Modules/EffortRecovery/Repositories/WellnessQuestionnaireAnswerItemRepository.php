<?php

namespace Modules\EffortRecovery\Repositories;

use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerItemRepositoryInterface;
use Modules\EffortRecovery\Entities\WellnessQuestionnaireAnswerItem;
use App\Services\ModelRepository;

class WellnessQuestionnaireAnswerItemRepository extends ModelRepository
    implements WellnessQuestionnaireAnswerItemRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    /**
     * @var string
     */
    protected $table = 'wellness_questionnaire_answer_items';

    /**
     * @var string
     */
    protected $tableTranslations = 'wellness_questionnaire_answer_item_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'wellness_questionnaire_answer_item_id';

    /**
     * Create a new repository instance
     */
    public function __construct(WellnessQuestionnaireAnswerItem $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return all effort recovery strategies with translations
     *
     * @return array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * Return all the set of question items depending on the type sent
     */
    public function findByTypeTranslated($typeId)
    {
        return $this->_model->select(
            'wellness_questionnaire_answer_items.id AS id',
            'wellness_questionnaire_answer_item_translations.name',
        )->join(
            'wellness_questionnaire_answer_item_translations',
            'wellness_questionnaire_answer_item_translations.wellness_questionnaire_answer_item_id',
            '=',
            'wellness_questionnaire_answer_items.id'
        )->where(
            'wellness_questionnaire_answer_items.wellness_questionnaire_answer_type_id', $typeId
        )->where(
            'wellness_questionnaire_answer_item_translations.locale', app()->getLocale()
        )->get();
    }
}
