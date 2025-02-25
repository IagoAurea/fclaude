<?php

namespace Modules\Injury\Database\Seeders;

use App\Services\BaseSeeder;
use Modules\Test\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionTableSeeder extends BaseSeeder
{
    
    /**
     * @var $questionRepository
     */
    protected $questionRepository;

    /**
     * @var array
     */
    protected $questions = [];

    /**
     * QuestionTableSeeder constructor.
     */
    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return void
     */
    protected function createQuestions()
    {
        $filename = "injury-test-questions.json";

        $elements = $this->getDataJson($filename);

        foreach($elements as $elm) {

            $questionsCreate = [
                'es' => [
                    'name' => $elm['name_spanish']
                ],
                'en' => [
                    'name' => $elm['name_english']
                ],
                'question_category_code' => $elm['question_category_code'],
                'code' => $elm['code']
            ];

            if (isset($elm['field_type'])){
                $questionsCreate['field_type'] = $elm['field_type'];
            }

            $this->questionRepository->create($questionsCreate);
        }
    }

    

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createQuestions();
    }
}
