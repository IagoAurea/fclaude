<?php

namespace Modules\Test\Database\Seeders;

use App\Services\BaseSeeder;
use Modules\Test\Repositories\Interfaces\QuestionRepositoryInterface;
use Modules\Test\Repositories\Interfaces\UnitRepositoryInterface;

class QuestionTableSeeder extends BaseSeeder
{
    /**
     * @var $questionRepository
     */
    protected $questionRepository;

    /**
     * @var $unitRepository
     */
    protected $unitRepository;

    /**
     * @var array
     */
    protected $questions = [];

    /**
     * QuestionTableSeeder constructor.
     */
    public function __construct(QuestionRepositoryInterface $questionRepository, UnitRepositoryInterface $unitRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->unitRepository = $unitRepository;
    }

    /**
     * @return void
     */
    protected function createQuestions()
    {
        $filename = "test-questions.json";

        $elements = $this->getDataJson($filename);

        foreach ($elements as $elm) {

            $questionsCreate = [
                'es' => [
                    'name' => $elm['name_spanish'],
                    'tooltip' => isset($elm['tooltip_spanish']) ? $elm['tooltip_spanish'] : NULL,
                ],
                'en' => [
                    'name' => isset($elm['name_english']) ? $elm['name_english'] : $elm['name_spanish'],
                    'tooltip' => isset($elm['tooltip_english']) ? $elm['tooltip_english'] : NULL,
                ],
                'question_category_code' => isset($elm['question_category_code']) ? $elm['question_category_code'] : NULL,
                'code' => $elm['code']
            ];

            if (isset($elm['unit'])) {
                $unit = $this->unitRepository->findOneBy(['code' => $elm['unit']]);

                $questionsCreate['unit_id'] = $unit->id ?? NULL;
            }
            if (isset($elm['field_type'])) {
                $questionsCreate['field_type'] = $elm['field_type'];
            }
            if (isset($elm['required'])) {
                $questionsCreate['required'] = $elm['required'];
            }
            if (isset($elm['is_configuration_question'])) {
                $questionsCreate['is_configuration_question'] = $elm['is_configuration_question'];
            }
            if (isset($elm['configuration_question_index'])) {
                $questionsCreate['configuration_question_index'] = $elm['configuration_question_index'];
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
