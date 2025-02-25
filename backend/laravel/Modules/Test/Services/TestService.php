<?php

namespace Modules\Test\Services;

use Exception;
use App\Helpers\Helper;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Modules\Test\Entities\TestFormula;
use Modules\Test\Entities\QuestionTest;
use Modules\Test\Entities\TableDetailValue;
use Modules\Test\Entities\QuestionResponse;
use Modules\Test\Entities\TestConfiguration;
use Modules\Test\Functions\CalculateFormulaFunction;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TableRepositoryInterface;
use Modules\Test\Repositories\Interfaces\FormulaRepositoryInterface;
use Modules\Test\Repositories\Interfaces\QuestionRepositoryInterface;
use Modules\Test\Repositories\Interfaces\ResponseRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TableDetailRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestFormulaRepositoryInterface;
use Modules\Test\Repositories\Interfaces\FormulaParamRepositoryInterface;
use Modules\Test\Repositories\Interfaces\ConfigurationRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestApplicationRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestConfigurationRepositoryInterface;

class TestService
{
    use ResponseTrait;

    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $questionRepository
     */
    protected $questionRepository;

    /**
     * @var $responseRepository
     */
    protected $responseRepository;

    /**
     * @var $testApplicationRepository
     */
    protected $testApplicationRepository;

    /**
     * @var $formulaFunction
     */
    protected $formulaFunction;

    /**
     * @var $formulaRepository
     */
    protected $formulaRepository;

    /**
     * @var $formulaParamRepository
     */
    protected $formulaParamRepository;

    /**
     * @var $testFormulaRepository
     */
    protected $testFormulaRepository;

    /**
     * @var $configRepository
     */
    protected $configRepository;

    /**
     * @var $testConfigRepository
     */
    protected $testConfigRepository;

    /**
     * @var $tableRepository
     */
    protected $tableRepository;

    /**
     * @var $tableDetailRepository
     */
    protected $tableDetailRepository;

    /**
     * @var $helper
     */
    protected $helper;

    public function __construct(
        TestRepositoryInterface $testRepository,
        QuestionRepositoryInterface $questionRepository,
        ResponseRepositoryInterface $responseRepository,
        TestApplicationRepositoryInterface $testApplicationRepository,
        CalculateFormulaFunction $formulaFunction,
        FormulaRepositoryInterface $formulaRepository,
        FormulaParamRepositoryInterface $formulaParamRepository,
        TestFormulaRepositoryInterface $testFormulaRepository,
        ConfigurationRepositoryInterface $configRepository,
        TestConfigurationRepositoryInterface $testConfigRepository,
        TableRepositoryInterface $tableRepository,
        TableDetailRepositoryInterface $tableDetailRepository,
        Helper $helper
    ) {
        $this->testRepository = $testRepository;
        $this->questionRepository = $questionRepository;
        $this->responseRepository = $responseRepository;
        $this->testApplicationRepository = $testApplicationRepository;
        $this->formulaFunction = $formulaFunction;
        $this->formulaRepository = $formulaRepository;
        $this->formulaParamRepository = $formulaParamRepository;
        $this->testFormulaRepository = $testFormulaRepository;
        $this->configRepository = $configRepository;
        $this->testConfigRepository = $testConfigRepository;
        $this->tableRepository = $tableRepository;
        $this->tableDetailRepository = $tableDetailRepository;
        $this->helper = $helper;
    }

    /**
     * Response success
     * @param json $new_questions
     * @param int $test_id
     * @return array
     */
    public function createQuestions($associate_questions, $test_id)
    {
        try {
            $questions = [];

            $associateQuestions = json_decode($associate_questions, $test_id);

            if ($associateQuestions != null) {
                foreach ($associateQuestions as $associate_question) {

                    $question = $this->questionRepository->findOneBy(["code" => $associate_question['question_code']]);

                    if ($associate_question['question_code'] == null) {

                        $question = "";

                        $questionCreate = [
                            'es' => [
                                'name' => $associate_question['name_spanish']
                            ],
                            'en' => [
                                'name' => $associate_question['name_english']
                            ],
                            'question_category_code' => $associate_question['question_category_code']
                        ];

                        if (isset($associate_question['field_type'])) {
                            $questionCreate['field_type'] = $associate_question['field_type'];
                        }
                        if (isset($associate_question['required'])) {
                            $questionCreate['required'] = $associate_question['required'];
                        }
                        if (isset($associate_question['is_configuration_question'])) {
                            $questionCreate['is_configuration_question'] = $associate_question['is_configuration_question'];
                        }

                        $question = $this->questionRepository->create($questionCreate);
                    }

                    $questionTest = new QuestionTest;
                    $questionTest->value = $associate_question['value'];
                    $questionTest->question_id =  $question->id;
                    $questionTest->test_id = $test_id;
                    $questionTest->save();

                    array_push($questions, $questionTest->id);

                    $responses = $this->createResponses($associate_question['associate_responses'], $questionTest->id);
                }
            }

            $result['questions'] = $questions;
            $result['responses'] = $responses['data'];

            return [
                'success' => true,
                'message' => "Questions Create",
                'data' => $result
            ];
        } catch (Exception $exception) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, $exception->getMessage());
        }
    }

    /**
     * Response success
     * @param array $new_responses
     * @param int $question_id
     * @return array
     */
    public function createResponses($associate_responses, $question_test_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        $responses = [];

        if ($associate_responses != null) {
            foreach ($associate_responses as $associate_response) {
                $response = $this->responseRepository->findOneBy(["code" => $associate_response['response_code']]);

                if ($associate_response['response_code'] == null) {
                    $response = "";
                    $response_create = [
                        'es' => [
                            'name' => $associate_response['name_spanish'],
                            'tooltip' => isset($associate_response['tooltip_spanish']) ?
                                $associate_response['tooltip_spanish'] : null
                        ],
                        'en' => [
                            'name' => $associate_response['name_english'],
                            'tooltip' => isset($associate_response['tooltip_english']) ?
                                $associate_response['tooltip_english'] : null
                        ]
                    ];

                    $response = $this->responseRepository->create($response_create);
                }

                $questionResponse = new QuestionResponse;
                $questionResponse->question_test_id =  $question_test_id;
                $questionResponse->response_id = $response->id;
                $questionResponse->value = $associate_response['value'];
                $questionResponse->cal_value = $associate_response['cal_value'];
                $questionResponse->is_index = $associate_response['is_index'];
                $questionResponse->laterality = $associate_response['laterality'];
                $questionResponse->save();

                array_push($responses, $questionResponse->id);
            }
        }

        $dataResponse['success'] = true;
        $dataResponse['message'] = "Response Create";
        $dataResponse['data'] = $responses;

        return $dataResponse;
    }

    /**
     * Response success
     * @param array $formulas
     * @param int $test_id
     * @return array
     */
    public function createFormula($formulas, $test_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        try {

            $test = $this->testRepository->find($test_id);

            if (!$test) {
                abort(response()->error("Test not found", Response::HTTP_NOT_FOUND));
            }

            $formulas_array = [];

            foreach ($formulas as $formula) {
                $formula_create = $this->formulaRepository->create($formula['formula']);

                $test_formula = new TestFormula;
                $test_formula->formula_id = $formula_create->id;
                $test_formula->test_id = $test->id;
                $test_formula->save();

                foreach ($formula['params'] as $param) {

                    $param['test_formula_id'] = $test_formula->id;

                    $this->formulaParamRepository->create($param);
                }

                array_push($formulas_array, $formula_create->formula);
            }

            $dataResponse['success'] = true;
            $dataResponse['message'] = "Formulas Create";
            $dataResponse['data'] = $formulas_array;
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        return $dataResponse;
    }

    /** Response success
     * @param array $configurations
     * @param int $test_id
     * @return array
     */
    public function createConfigurations($configurations, $test_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        try {

            $test = $this->testRepository->find($test_id);

            if (!$test) {
                abort(response()->error("Test not found", Response::HTTP_NOT_FOUND));
            }

            $configurations_array = [];

            $configurations = json_decode($configurations, $test_id);

            foreach ($configurations as $configuration) {

                $test_configuration = new TestConfiguration;
                $test_configuration->configuration_id = $configuration;
                $test_configuration->test_id = $test->id;
                $test_configuration->save();


                array_push($configurations_array, $test_configuration->id);
            }

            $dataResponse['success'] = true;
            $dataResponse['message'] = "Configurations Create";
            $dataResponse['data'] = $configurations_array;
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        return $dataResponse;
    }

    /** Response success
     * @param array $table
     * @param int $test_id
     * @return array
     */
    public function createTable($table, $test_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        try {
            $test = $this->testRepository->find($test_id);

            if (!$test) {
                abort(response()->error("Test not found", Response::HTTP_NOT_FOUND));
            }

            $config = $this->configRepository->findBy([
                'code' => 'chart',
                'is_table' => 'true'
            ])->first();

            $test_configuration =  $this->testConfigRepository->findBy([
                'configuration_id' => $config->id,
                'test_id' => $test_id
            ])->first();

            if (!$test_configuration) {
                abort(response()->error("Test table configuration not found", Response::HTTP_NOT_FOUND));
            }

            $table_json = json_decode($table, $test_id);

            $tableCreate = [
                'es' => [
                    'name' => $table_json['name_spanish'],
                    'description' => $table_json['description_spanish']
                ],
                'en' => [
                    'name' => $table_json['name_english'],
                    'description' => $table_json['description_english']
                ],
                'test_configuration_id' => $test_configuration->id
            ];

            $table = $this->tableRepository->create($tableCreate);

            foreach ($table_json['details'] as $detail) {

                $tableDetailCreate = [
                    'es' => [
                        'name' => $detail['name_spanish'],
                        'description' => $detail['description_spanish']
                    ],
                    'en' => [
                        'name' => $detail['name_english'],
                        'description' => $detail['description_english']
                    ],
                    'table_id' => $table->id,
                    'is_index' =>  $detail['is_index'],
                    'code' =>  $detail['code'],
                ];

                $table_detail = $this->tableDetailRepository->create($tableDetailCreate);

                $i = 0;

                foreach ($detail['values'] as $value) {
                    $detail_value = new TableDetailValue;
                    $detail_value->table_detail_id = $table_detail->id;
                    $detail_value->value = $value;
                    $detail_value->order = $i;
                    $detail_value->save();

                    $i++;
                }
            }

            $dataResponse['success'] = true;
            $dataResponse['message'] = "Configurations Table Create";
            $dataResponse['data'] = $table;
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        return $dataResponse;
    }

    /**
     * Response success
     * @param int $test_application_id
     * @return int
     */
    public function calculateTestResult($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        if (!$testApplication) {
            abort(response()->error("Test Application not found", Response::HTTP_NOT_FOUND));
        }

        $configurations = [
            "average" => function ($test_application_id) {
                return $this->calculateAverage($test_application_id);
            },
            "median" => function ($test_application_id) {
                return $this->calculateMedian($test_application_id);
            },
            "chart" => function ($test_application_id) {
                return $this->findChartResult($test_application_id);
            },
            "new_score" => function ($test_application_id) {
                return $this->calculateScore($test_application_id, "+");
            },
            "score_positive" => function ($test_application_id) {
                return $this->calculateScore($test_application_id, "+");
            },
            "score_negative" => function ($test_application_id) {
                return $this->calculateScore($test_application_id, "-");
            }
        ];

        $type_valorations = [
            "percentage" => function ($test_application_id) {
                return $this->calculateSumAnswers($test_application_id);
            },
            "points"  => function ($test_application_id) {
                return $this->calculateSumAnswers($test_application_id);
            },
            "weight" => function ($test_application_id) {
                return $this->calculateWeightAnswers($test_application_id);
            },
            "measurement" => function ($test_application_id) {
                return $this->calculateMeasurementAnswers($test_application_id);
            },
            "new_score" => function ($test_application_id) {
                return $this->calculateNewScoreAnswers($test_application_id);
            },
            "symmetric_difference" => function ($test_application_id) {
                return $this->calculateSymmetricDifferenceAnswers($test_application_id);
            },
            "qualitative" => function ($test_application_id) {
                return $this->calculateQualitativeAnswers($test_application_id);
            },
            "average_item" => function ($test_application_id) {
                return $this->calculateAverageItem($test_application_id);
            },
            "average_symmetric" => function ($test_application_id) {
                return $this->calculateAverageSymmetric($test_application_id);
            }
        ];

        $resultTest = [];

        $resultTest = [
            'id' => $testApplication->id,
            'code' => $testApplication->code
        ];

        // SEARCH THE RELATED TEST
        $test = $testApplication->test;

        if (!$test) {
            abort(response()->error("Test not found", Response::HTTP_NOT_FOUND));
        }

        $resultTest['type']  = $test->type_valoration_code;

        //CONFIGURATIONS CHECK
        foreach ($test->configurations as $configuration) {
            $config = $configurations[$configuration->code]($testApplication->id);

            $resultTest[$configuration->code] = $config;
        }

        // SOLVE TEST FORMULAS
        $formulas_array = [];

        if (count($test->formulas) > 0) {
            foreach ($test->formulas as $formula) {
                $params = $this->getParams($formula->id, $test->id, $testApplication->id, $config);

                $params = $params['data'];

                $calculate_formula = $this->formulaFunction->getResult($params, $formula->formula);

                $formula_result['result'] = number_format((float) $calculate_formula['0']->calculate_formula, 2, '.', '');

                $formula_translate = $this->translateFormula($formula->id, $test->id);

                $formula_result['formula'] =  $formula_translate['data'];
                $formula_result['name'] =  $formula->name;
                $formula_result['description'] =  $formula->description;

                $formula_result['unit'] = $formula->unit->makeHidden('translations') ?? null;

                array_push($formulas_array, $formula_result);
            }
        }

        $resultTest['formulas'] = $formulas_array;

        // EVALUATE TEST
        $resultTest['value'] = (empty($type_valorations[$test->type_valoration_code])) ?
            $this->calculateSumAnswers($testApplication) :
            $type_valorations[$test->type_valoration_code]($testApplication->id);

        // SEND RESPONSE
        return [
            "success" => true,
            "message" => "Test Result",
            "data" => $resultTest
        ];
    }

    /**
     * Response success
     * @param array $answers
     * @param int $test_id
     * @return array
     */
    public function validateAnswers($answers, $test_id)
    {
        $dataResponse = [
            "success" => true,
            "data" => "",
        ];

        $answers_filter = [];
        $question_ok = [];

        foreach ($answers as $answer) {
            $questionResponse = QuestionResponse::find($answer['id']);
            $questionTest = $questionResponse->question_test;
            $id_test = $questionTest->test_id;

            if ($test_id == $id_test && !in_array($questionTest->id, $question_ok)) {
                array_push($answers_filter, $answer);
                array_push($question_ok, $questionTest->id);
            }
        }

        $dataResponse['success'] = true;
        $dataResponse['message'] = "Answers Validate ";
        $dataResponse['data'] = $answers_filter;

        return $dataResponse;
    }

    //functions formula

    /**
     * Response success
     * @param int $formula_id
     * @param int $test_id
     * @param int $test_application_id
     * @return Response
     */
    public function getParams($formula_id, $test_id, $test_application_id, $config)
    {
        $params_array = [];

        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        $formula_test = $this->testFormulaRepository
            ->findBy(['formula_id' => $formula_id, 'test_id' => $test_id])
            ->first();

        if (!$formula_test) {
            abort(response()->error("Formula in test not found", Response::HTTP_NOT_FOUND));
        }

        $params = $formula_test->formula_params;

        if (count($params) <= 0) {
            abort(response()->error("Formula not have params", Response::HTTP_NOT_FOUND));
        }

        $testApplication = $this->testApplicationRepository->find($test_application_id);

        if (!$testApplication) {
            abort(response()->error("Test Application not found", Response::HTTP_NOT_FOUND));
        }

        $answers = $testApplication->answers;

        $answers_array =  $testApplication->answers()->get()->toArray();

        foreach ($params as $param) {
            if ($param->type == 'input') {
                $answers_count = 0;

                foreach ($answers as $answer) {
                    if ($answer->question_responses_id == $param->question_responses_id) {
                        array_push($params_array, $answers_array[$answers_count]['value']);
                    }

                    $answers_count =   $answers_count + 1;
                }
            }

            if ($param->type == 'calculate') {
                $table_detail = $this->tableDetailRepository->findOneBy(['code' => $param->code]);

                if (!$table_detail) {
                    continue;
                }

                if ($config === 'N/A') {
                    continue;
                }

                array_push($params_array, $config[$table_detail->name]);
            }
        }

        for ($i = count($params_array); $i < 10; $i++) {
            array_push($params_array, null);
        }

        $dataResponse['success'] = true;
        $dataResponse['message'] = "Params by formula ";
        $dataResponse['data'] = $params_array;

        return $dataResponse;
    }

    /**
     * Response success
     * @param int $formula_id
     * @param int $test_id
     * @return Response
     */
    public function translateFormula($formula_id, $test_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        $formula_test = $this->testFormulaRepository->findBy([
            'formula_id' => $formula_id,
            'test_id' => $test_id
        ])->first();

        if (!$formula_test) {
            abort(response()->error("Formula in test not found", Response::HTTP_NOT_FOUND));
        }

        $params = $formula_test->formula_params;

        if (count($params) <= 0) {
            abort(response()->error("Formula not have params", Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        $formula_translate = $formula_test->formula->formula;

        foreach ($params as $param) {
            $formula_translate = str_replace('$' . $param->param, $param->code, $formula_translate);
        }

        $dataResponse['success'] = true;
        $dataResponse['message'] = "Translate formula ";
        $dataResponse['data'] = $formula_translate;

        return $dataResponse;
    }


    //functions configurations

    /**
     * Calculate average
     * @param object $testApplication
     * @return decimal
     */
    private function calculateAverage($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $nums = [];

        $answers = $testApplication->answers;

        foreach ($answers as $answer) {
            if ($answer->question_responses->cal_value) {
                array_push($nums, $answer->value);
            }
        }

        if (count($nums) >= 2) {
            $sum = array_sum($nums);

            $media = number_format($sum / count($nums), 2, '.', '');

            $testApplication->average = $media;
            $testApplication->update();

            return $media;
        }

        return 'N/A';
    }

    /**
     * Calculate median
     * @param object $testApplication
     * @return decimal
     */
    private function calculateMedian($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $nums = [];

        $answers = $testApplication->answers;

        foreach ($answers as $answer) {
            if ($answer->question_responses->cal_value) {
                array_push($nums, $answer->value);
            }
        }

        if (count($nums) >= 3) {

            sort($nums);

            $count = count($nums);

            $middleval = floor(($count - 1) / 2);

            if ($count % 2) {
                $median = $nums[$middleval];
            } else {
                $low = $nums[$middleval];
                $high = $nums[$middleval + 1];
                $median = (($low + $high) / 2);
            }

            $testApplication->median = $median;

            $testApplication->update();

            return $median;
        }

        return 'N/A';
    }

    /**
     * Response success
     * @param object $testApplication
     * @return decimal
     */
    private function calculateScore($test_application_id, $operator)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $score = 0;

        $nums = [];

        $answers = $testApplication->answers;

        foreach ($answers as $answer) {
            if ($answer->question_responses->cal_value && $answer->value > 0) {
                array_push($nums, $answer->value);
            }
        }

        if (count($nums) == 0) {
            $nums = [$score];
        }

        $score = $operator == "-" ? min($nums) : max($nums);

        $testApplication->score = $score;

        $testApplication->update();

        return $score;
    }

    /**
     * Calculate chart
     * @param object $testApplication
     * @return array
     */
    private function findChartResult($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $table_details = [];

        $answers = $testApplication->answers;

        $value_response = null;

        foreach ($answers as $answer) {
            if ($answer->question_responses->is_index) {
                $value_response =  $answer->value;
            }
        }

        $config = $this->configRepository->findBy(['code' => 'chart', 'is_table' => 'true'])->first();

        $test_configuration =  $this->testConfigRepository
            ->findBy(['configuration_id' => $config->id, 'test_id' => $testApplication->test->id])
            ->first();

        if (!$test_configuration) {
            abort(response()->error("Test table configuration not found", Response::HTTP_NOT_FOUND));
        }

        $test_configuration->table;

        // get order to make resume
        $order = null;

        foreach ($test_configuration->table->table_details as $column_table) {
            if ($column_table->is_index) {
                foreach ($column_table->table_detail_values as $row_table) {
                    if ($row_table->value ==  $value_response) {
                        $order = $row_table->order;
                    }
                }
            }
        }

        $testApplication->chart_order = $order;
        $testApplication->update();

        foreach ($test_configuration->table->table_details as $column_table) {
            if ($column_table->is_index) {
                $table_details['index'] = $column_table->name;
            }

            foreach ($column_table->table_detail_values as $row_table) {
                if ($row_table->order == $order) {
                    $table_details[$column_table->name] = $row_table->value;
                }
            }
        }

        return $table_details;
    }

    //functions valoration

    /**
     * Calculate sum average
     * @param object $testApplication
     * @return decimal
     */
    private function calculateSumAnswers($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $result = 0;

        $answers = $testApplication->answers;

        foreach ($answers as $answer) {
            $question_response = $answer->question_responses;

            $question_test =  $question_response->question_test;

            $value = $question_response->value;

            if ($value > $question_test->value) {
                $value = $question_test->value;
            }

            if ($answer->text_response != "" && is_numeric($answer->text_response)) {
                $value = floatval($answer->text_response);
            }

            $result = $result + $value;
        }

        $testApplication->result = $result;

        $testApplication->update();

        return $result;
    }

    /**
     * Calculate weight answers
     * @param object $testApplication
     * @return decimal
     */
    private function calculateWeightAnswers($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $result = 0;
        $nums = [];

        $testApplicationPrevious = 0;

        $answers = $testApplication->answers;

        foreach ($answers as $answer) {
            if ($answer->question_responses->cal_value) {
                array_push($nums, $answer->value);
            }
        }
        $sum = array_sum($nums);

        $result = count($nums) >= 2 ? $testApplication->average : floatval($sum);

        $testApplicationPrevious =  $this->testApplicationRepository->findPreviousApplication($testApplication->id);

        $previous_result = 0;

        $diff = "n/a";

        if ($testApplicationPrevious) {
            $previous_result = floatval($testApplicationPrevious->result);

            $diff = $result - $testApplicationPrevious->result;
        }

        $testApplication->result = $result;
        $testApplication->update();

        return [
            'previous_result' => $previous_result,
            'result' => $result,
            'diference' => $diff
        ];
    }
    /**
     * Calculate measurement answers
     * @param object $testApplication
     * @return array
     */
    private function calculateMeasurementAnswers($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $answers = $testApplication->answers;

        $testApplicationPrevious =  $this->testApplicationRepository->findPreviousApplication($testApplication->id);

        if ($testApplicationPrevious) {
            $answers_previos_array =  $testApplicationPrevious->answers()->get()->toArray();
        }

        $answers_count = 0;
        $measurement_result = [];

        foreach ($answers as $answer) {
            if ($answer->question_responses->cal_value) {
                $question = $this->questionRepository->find($answer->question_id);

                $measurement_result[$answer->id]['answer_name'] =  $answer->question;
                $measurement_result[$answer->id]['answer_value'] = $answer->value;
                $measurement_result[$answer->id]['unit'] = $question->unit;
                $measurement_result[$answer->id]['previous_answer_value'] = $testApplicationPrevious ? $answers_previos_array[$answers_count]['value'] : 0;
                $measurement_result[$answer->id]['diff'] = $testApplicationPrevious ? $answer->value - $answers_previos_array[$answers_count]['value'] : "n/a";
            }

            $answers_count = $answers_count + 1;
        }

        $testApplication->result =  $measurement_result;
        $testApplication->update();

        return $measurement_result;
    }

    /**
     * Calculate new score for answers test application
     * @param object $testApplication
     * @return array
     */
    private function calculateNewScoreAnswers($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $result = 0;
        $testApplicationsPrevious = 0;
        $previous_results = [];

        $result = $testApplication->score;
        $max = $result;
        $min = $result;

        $testApplication->result =  $result;
        $testApplication->update();

        $testApplicationsPrevious =  $this->testApplicationRepository->findAllPreviousApplications($testApplication->id);

        foreach ($testApplicationsPrevious as $previous_application) {
            if ($previous_application->result > $max) {
                $max = $previous_application->result;
            }

            if ($previous_application->result < $min) {
                $min = $previous_application->result;
            }

            $previous_results[$previous_application->id]['date'] = $previous_application->date_application;
            $previous_results[$previous_application->id]['result'] = $previous_application->result;

            $diff = $result >= $previous_application->result ? "+" : "";

            $calculate_diff = $result - $previous_application->result;

            $previous_results[$previous_application->id]['diff'] = $diff . (string) $calculate_diff;
        }

        //TODO: Devolver unidad de medida
        $test = $this->testRepository->find($testApplication->test_id);

        $configuration = $test->configurations->where('code', 'score_negative')->first();

        $inverse = is_null($configuration);

        return [
            'previous_best_score' => $inverse ? $max : $min,
            'previous_worst_score' => $inverse ? $min : $max,
            'new_best_score' => $inverse ? $result >= $max : $result <= $min,
            'result' => $result,
            'previous_result' => $previous_results
        ];
    }

    /**
     * Calculate symmetric difference answers
     * @param object $testApplication
     * @return array
     */
    private function calculateSymmetricDifferenceAnswers($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $right_array = [];
        $left_array = [];
        $difference_array = [];

        $answers = $testApplication->answers;

        foreach ($answers as $answer) {
            if ($answer->question_responses->laterality == "RIGHT") {

                $righ['value'] = $answer->value;
                $righ['name'] = $answer->question;
                $righ['id'] = $answer->question_id;

                array_push($right_array, $righ);
            } else {

                $left['value'] = $answer->value;
                $left['name'] = $answer->question;
                $left['id'] = $answer->question_id;

                array_push($left_array, $left);
            }
        }

        foreach ($left_array as $left) {
            foreach ($right_array as $righ) {
                if ($left['id'] == $righ['id']) {
                    $difference_array[$left['id']]['name'] = $left['name'];
                    $difference_array[$left['id']]['left'] = $left['value'];
                    $difference_array[$left['id']]['righ'] = $righ['value'];
                    $difference_array[$left['id']]['diff'] = $left['value'] - $righ['value'];
                }
            }
        }
        $testApplication->result =  $difference_array;
        $testApplication->update();

        return $difference_array;
    }

    /**
     * Calculate qualitative answers
     * @param object $testApplication
     * @return array
     */
    private function calculateQualitativeAnswers($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $resume = [];

        $response = [];

        $answers = $testApplication->answers;

        foreach ($answers as $answer) {
            $resume[$answer->question] = $answer->response;

            $question_response = $answer->question_responses;
            array_push($response, [
                'question' => $answer->question,
                'response' => $answer->response,
                'color' => $answer->color,
                'image' => $answer->image,
                'cal_value' => $question_response->cal_value ?? null
            ]);
        }

        $testApplication->result =  $resume;
        $testApplication->update();

        $previous_results = [];

        $testApplicationPrevious =  $this->testApplicationRepository->findPreviousApplication($testApplication->id);

        if ($testApplicationPrevious) {
            $result = [];

            if (!is_null($testApplicationPrevious->result)) {
                $result = json_decode($testApplicationPrevious->result, true);

                $answers = $testApplicationPrevious->answers;

                foreach ($answers as $answer) {
                    $question_response = $answer->question_responses;

                    array_push($previous_results, [
                        'question' => $answer->question,
                        'response' => $result[$answer->question],
                        'color' => $answer->color,
                        'image' => $answer->image,
                        'cal_value' => $question_response->cal_value ?? null
                    ]);
                }
            }
        }

        return [
            'result' => $response,
            'previous_result' => $previous_results
        ];
    }

    /**
     * Caculate valoration average item
     * @param object $testApplication
     * @return array
     */
    private function calculateAverageItem($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $resume = [];
        $result = [];
        $response = [];
        $previous_results = [];

        $testApplicationPrevious =  $this->testApplicationRepository->findPreviousApplication($testApplication->id);

        if (isset($testApplicationPrevious->result)) {
            $previous_results = json_decode($testApplicationPrevious->result, true);
        }

        $answers = $testApplication->answers;

        foreach ($answers as $answer) {
            if ($answer->value <= 0 || !isset($answer->question_responses->laterality)) {
                continue;
            }

            $total = isset($result[$answer->question_responses->laterality]) ? $result[$answer->question_responses->laterality]['total'] + $answer->value : $answer->value;
            $length = isset($result[$answer->question_responses->laterality]) ? $result[$answer->question_responses->laterality]['length'] + 1 : 1;
            $average = number_format($total / $length, 2, '.', '');
            $best = !isset($result[$answer->question_responses->laterality]['best']) ? $answer->value : $result[$answer->question_responses->laterality]['best'];

            if ($best < $answer->value) {
                $best = $answer->value;
            }

            $result[$answer->question_responses->laterality] = [
                'total' => $total,
                'length' => $length,
                'average' => $average
            ];

            $question = $this->questionRepository->find($answer->question_id);

            $response[$answer->question_responses->laterality] = [
                'question' => $answer->question,
                'response' => $average,
                'unit' => $question->unit,
                'previous_answer_value' => isset($previous_results[$answer->question]) ? $previous_results[$answer->question] : 0,
                'diff' => isset($previous_results[$answer->question]) ?
                    number_format($average - $previous_results[$answer->question], 2, '.', '') :
                    number_format((float) $average, 2, '.', ''),
                'best' => $best
            ];

            $resume[$answer->question] = $average;
            $result[$answer->question_responses->laterality]['best'] = $best;
        }

        $testApplication->result = $response;
        $testApplication->update();

        $previous_results = [];

        $testApplicationPrevious =  $this->testApplicationRepository->findPreviousApplication($testApplication->id);

        if ($testApplicationPrevious) {
            $result = [];

            if (!is_null($testApplicationPrevious->result)) {
                $result = json_decode($testApplicationPrevious->result, true);

                foreach ($result as $resp => $answer) {
                    $previous_results[$resp] = $answer;
                }
            }
        }

        return [
            'result' => $response,
            'previous_result' => $previous_results
        ];
    }

    /**
     * Caculate valoration average item
     * @param object $testApplication
     * @return array
     */
    private function calculateAverageSymmetric($test_application_id)
    {
        $testApplication = $this->testApplicationRepository->find($test_application_id);

        $right_result = [
            'length' => 0,
            'total' => 0,
            'average' => 0
        ];

        $left_result = [
            'length' => 0,
            'total' => 0,
            'average' => 0
        ];

        $resume = [];

        $answers = $testApplication->answers;

        foreach ($answers as $key => $answer) {
            if ($answer->question_responses->laterality == "RIGHT") {
                $right_result['total'] += $answer->value;
                $right_result['length'] += 1;
                $right_result['average'] = number_format($right_result['total'] / $right_result['length'], 2, '.', '');

                $resume[$this->helper->textWithoutNumbers($answer->question)] = $right_result['average'];
                $resume['right'] = $right_result['average'];

                $best_right = !isset($resume['best_right']) ? $answer->value : $resume['best_right'];

                if ($best_right < $answer->value) {
                    $best_right = $answer->value;
                }

                $resume['best_right'] = $best_right;
            } else {
                $left_result['total'] += $answer->value;
                $left_result['length'] += 1;
                $left_result['average'] = number_format($left_result['total'] / $left_result['length'], 2, '.', '');

                $resume[$this->helper->textWithoutNumbers($answer->question)] = $left_result['average'];
                $resume['left'] = $left_result['average'];

                $best_left = !isset($resume['best_left']) ? $answer->value : $resume['best_left'];

                if ($best_left < $answer->value) {
                    $best_left = $answer->value;
                }

                $resume['best_left'] = $best_left;
            }
        }

        $testApplication->result = $resume;
        $testApplication->update();

        $previous_results = [];

        $testApplicationPrevious =  $this->testApplicationRepository->findPreviousApplication($testApplication->id);

        if ($testApplicationPrevious) {
            $result = [];

            if (!is_null($testApplicationPrevious->result)) {
                $result = json_decode($testApplicationPrevious->result, true);

                foreach ($result as $resp => $answer) {
                    $previous_results[$resp] = $answer;
                }
            }
        }

        return [
            'result' => $resume,
            'previous_result' => $previous_results
        ];
    }
}
