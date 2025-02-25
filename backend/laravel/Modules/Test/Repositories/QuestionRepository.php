<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\Question;
use Modules\Test\Entities\QuestionCategory;
use Modules\Test\Repositories\Interfaces\QuestionRepositoryInterface;
use Modules\Test\Repositories\Interfaces\QuestionCategoryRepositoryInterface;

class QuestionRepository extends ModelRepository implements QuestionRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'questions';

    /**
     * @var string
    */
    protected $tableTranslations = 'question_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'question_id';

    /**
     * @var object
    */
    protected $model;

    /**
     * @var object
    */
    protected $questionCategoryModel;

    /**
     * @var object
    */
    protected $questionCategoryRepository;

    public function __construct(
        Question $model,
        QuestionCategory $questionCategoryModel,
        QuestionCategoryRepositoryInterface $questionCategoryRepository
    )
    {
        $this->model = $model;
        $this->questionCategoryModel = $questionCategoryModel;
        $this->questionCategoryRepository = $questionCategoryRepository;

        parent::__construct($this->model);
    }

    /**
     *  Return Question type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * Store a newly created resource in storage.
     * @param String $category_code 
     * @return Array
     */
    public function questionsByCategory($category_code)
    {
        $locale = app()->getLocale();

        $questionCategory =  $this->questionCategoryRepository->findOneBy(["code" => $category_code]);

        if ($questionCategory->question_category_code == null) {

            $listOfQuestions = $this->model
            ->where('question_category_code',$category_code)
            ->with(['question_category' => function ($query) use ($locale) {
                $query->select('question_categories.id','question_categories.code')
                ->withTranslation($locale);
            }])
            ->get(); 
      
        }

        return  $listOfQuestions;
    }

     /**
     * Return Question test find.
     * @param String $question_code 
     * @param String $test 
     * @return Object
     */
    public function questionTest($question_code, $test)
    {
        return $this->model
            ->with(['tests' => function($query) use($test){
                    $query->where('tests.id', $test);
                }]
            )
            ->select('id', 'code')
            ->where('code', $question_code)
            ->first();
    }

    

}