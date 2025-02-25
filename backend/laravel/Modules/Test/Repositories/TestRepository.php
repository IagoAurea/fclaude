<?php

namespace Modules\Test\Repositories;

use Modules\Test\Entities\Test;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Test\Entities\TestType;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;

class TestRepository extends ModelRepository implements TestRepositoryInterface
{
    const TYPES = [
        'rfd' => TestType::CLASSIFICATION_RFD,
        'test' => TestType::CLASSIFICATION_TEST
    ];

    /**
     * @var string
     */
    protected $table = 'tests';

    /**
     * @var string
     */
    protected $tableTranslations = 'test_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'test_id';

    /**
     * @var object
     */
    protected $model;

    public function __construct(
        Test $model
    ) {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return test type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     *  Return Question type translations
     *
     */
    public function findAllImage($request)
    {
        $locale = $request->has('_locale') ? $request->_locale : app()->getLocale();

        $listSubType = $this->model
            ->withTranslation($locale)
            ->with('image', 'test_type', 'test_sub_type')
            ->when($request->has('type'), function ($query) use ($request) {
                if ($request->type == 'all') {
                    return $query;
                }
                $query->whereRelation('test_type', 'classification', TestType::CLASSIFICATION_BOTH);
                return $query->orWhereRelation('test_type', 'classification', self::TYPES[$request->type]);
            })
            ->get();

        $listSubType->makeHidden('translations');

        return  $listSubType;
    }

    /**
     *  Return test complete
     *
     */
    public function findTestAll($test_id, $_locale)
    {
        $relations = $this->getModelRelations($_locale);

        $test = $this->model
            ->with($relations)
            ->find($test_id);

        if (!$test) {
            throw new Exception("Test not found");
        }

        $test->makeHidden('test_type_id');
        $test->makeHidden('translations');
        $test->test_type->makeHidden('translations');
        $test->question_test->makeHidden('test_id');
        $test->question_test->makeHidden('question_id');

        return $test;
    }

    /**
     * Private function to retrieve needed model relations in order to not to repeat
     * the same code on every query sent
     * 
     * @return Array
     */

    private function getModelRelations($_locale)
    {
        $locale = $_locale ? $_locale : app()->getLocale();

        return [
            'test_type' => function ($query) use ($locale) {
                $query->select('test_types.id')
                    ->withTranslation($locale);
            },
            'question_test' => function ($query) use ($locale) {
                $query->with([
                    'question' => function ($query) use ($locale) {
                        $query->select(
                            'questions.id', 'questions.question_category_code', 'questions.field_type', 
                            'questions.is_configuration_question', 'questions.required', 'questions.unit_id'
                            )
                            ->with([
                                'question_category' => function ($query) use ($locale) {
                                    $query->select('question_categories.id', 'question_categories.code')
                                        ->withTranslation($locale);
                                }
                            ])
                            ->with([
                                'unit' => function ($query) use ($locale) {
                                    $query->select('units.id', 'units.code', 'units.abbreviation')
                                        ->withTranslation($locale);
                                }
                            ])
                            ->withTranslation($locale);
                    },
                    'responses' => function ($query) use ($locale) {
                        $query->select('responses.color', 'responses.id', 'responses.image_id')
                            ->withPivot('id as question_responses_id', 'value as value', 'cal_value as cal_value', 'is_index as index', 'laterality as laterality')
                            ->withTranslation($locale)
                            ->with([
                                'image' => function ($query) {
                                    $query->select('resources.*');
                                }
                            ]);
                    },
                ]);
            },

        ];
    }
}
