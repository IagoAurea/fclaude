<?php

namespace Modules\Test\Repositories;

use Exception;
use Carbon\Carbon;
use Modules\User\Entities\User;
use Modules\Test\Entities\Test;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Player;
use Modules\Fisiotherapy\Entities\File;
use  Modules\Injury\Entities\PhaseDetail;
use Modules\Test\Entities\TestApplication;
use Modules\Training\Entities\ExerciseSession;
use Modules\Test\Entities\TestApplicationAnswer;
use Modules\Test\Repositories\Interfaces\TestApplicationRepositoryInterface;

class TestApplicationRepository extends ModelRepository implements TestApplicationRepositoryInterface
{
    /**
     * Relatable classes to be used on the application test table
     */
    const CLASS_NAMES = [
        'user'   =>  User::class,
        'rfd'    =>  PhaseDetail::class,
        'player' => Player::class,
        'fisiotherapy' => File::class,
        'test' => Test::class,
        'exercise_session' => ExerciseSession::class
    ];

    /**
     * Relatable modules to be used on the application test table
     */
    const MODELS_PATH = [
        'Modules\Injury\Entities\PhaseDetail' => 'PhaseDetail',
        'Modules\Test\Entities\Test' => 'Test',
        'Modules\Player\Entities\Player' => 'Player',
        'Modules\Alumn\Entities\Alumn' => 'Alumn',
        'Modules\User\Entities\Player' => 'User',
        'Modules\Fisiotherapy\Entities\File' => 'File',
        'Modules\Training\Entities\ExerciseSession' => 'ExerciseSession'
    ];

    /**
     * @var string
     */
    protected $table = 'test_applications';

    /**
     * @var object
     */
    protected $model;

    public function __construct(
        TestApplication $model
    ) {
        $this->model = $model;
        parent::__construct($this->model);
    }

    public function findApplicationSessionExercise($type, $exercise_session, $entity)
    {
        $application = $this->model
            ->where('applicable_type', ExerciseSession::class)
            ->where('applicable_id', $exercise_session)
            ->where('applicant_type', get_class($entity))
            ->where('applicant_id', $entity->id)
            ->whereHas('test', function ($query) use ($type) {
                $query->where('code', $type);
            });

            return $application->first();
    }

    public function createTestApplication($application)
    {
        $entityClass = $this->resolveEntityClassName($application['entity_name']);
        
        $application['applicable_type'] = $entityClass;

        $testApplication = $this->create($application);

        foreach ($application['answers'] as $response) {
            $answer = [];

            $answer['test_application_id'] =  $testApplication->id;
            $answer['question_responses_id'] =  $response['id'];
            if (isset($response['unit_id'])) {
                $answer['unit_id'] =  $response['unit_id'];
            }

            if (isset($response['text']))
                $answer['text_response'] =  $response['text'];

            $new_answer = new TestApplicationAnswer;
            $save_answer = $new_answer->create($answer);
            $save_answer->save();
        }

        return $testApplication;
    }

    public function updateTestApplication($application_id, $request)
    {
        DB::beginTransaction();

        try {
            $testApplication = $this->model::find($application_id);

            if (!$testApplication) {
                throw new Exception("Test Application  not found");
            }

            $answers = $testApplication->answers;

            TestApplicationAnswer::whereIn('id', $answers->pluck('id'))->delete();

            foreach ($request['answers'] as $response) {
                $answer = [];

                $answer['test_application_id'] =  $testApplication->id;
                $answer['question_responses_id'] =  $response['id'];
                $answer['text_response'] =  $response['text'];
                
                $new_answer = new TestApplicationAnswer;
                $save_answer = $new_answer->create($answer);
                $save_answer->save();
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return $exception;
        }

        return $testApplication;
    }

    public function findTestApplicationAll($test_application_id, $full_relations = false)
    {
        $testApplication = $this->model
            ->with(
                'applicable', 'applicant', 'professional_direct', 'answers'
            )
            ->where('id', $test_application_id);
        
        if ($full_relations) {
            $testApplication = $testApplication->with(
                'applicable.test_type', 'applicable.test_sub_type',
                'applicable.formulas', 'applicable.configurations',
                'applicable.question_test'
            );
        }

        return $testApplication->first();
    }

    public function findFirstTestApplication($code)
    {
        $testApplication = $this->model
            ->with(
                'applicable', 'applicant', 'professional_direct', 'answers'
            )
            ->where('code', $code);
    
        $testApplication = $testApplication->first();

        if(self::MODELS_PATH[$testApplication->applicant_type] == 'Player') {
            $testApplication->load([
                'applicant.position', 'applicant.team', 'applicant.team.modality', 'applicant.weight_controls'
            ]);
        }
        
        if (self::MODELS_PATH[$testApplication->applicable_type] !== 'PhaseDetail') {
            $testApplication->load([
                'applicable.test_type', 'applicable.test_sub_type', 'applicable.formulas',
                'applicable.configurations', 'applicable.question_test'
            ])->with(['applicable' => function ($query) {
                $query->with('question_test.unit');
            }]);
        }

        return $testApplication;
    }

    public function findTestApplicationDetail($id)
    {
        return $this->model
            ->with($this->getModelRelations())
            ->where('id', $id)
            ->first();
    }

    public function findByEntity($class, $entity_id, $filters = [])
    {
        return $this->model
            ->with('applicable', 'answers', 'applicant', 'test', 'test.test_type', 'test.test_sub_type')
            ->where([
                "applicant_type" => $class,
                "applicant_id" => $entity_id
            ])
            ->when(isset($filters['orderByDate']), function ($query) use ($filters) {
                return $query->orderBy('date_application', $filters['orderByDate']);
            })
            ->when(isset($filters['applicable_type']), function ($query) use ($filters) {
                return $query->where('applicable_type', $filters['applicable_type']);
            })
            ->when(isset($filters['filterByDate']), function ($query) use ($filters) {
                return $query->where('start_at', '>=', Carbon::parse($filters['filterByDate']));
            })
            ->when(isset($filters['test_type']), function ($query) use ($filters) {
                return $query->whereHas('test.test_type', function($q) use($filters) {
                    $q->where('code', $filters['test_type']);
                });
            })
            ->when(isset($filters['test_sub_type']), function ($query) use ($filters) {
                return $query->whereHas('test.test_sub_type', function($q) use ($filters){
                    $q->where('code', $filters['test_sub_type']);
                });
            })
            ->get();
    }

    public function findPreviousApplication($test_application_id)
    {
        $testApplication = $this->model->find($test_application_id);

        return $this->model
            ->where('applicant_id', '=', $testApplication->applicant_id)
            ->where('applicant_type', '=', $testApplication->applicant_type)
            ->where('test_id', '=', $testApplication->test_id)
            ->where('id', '<>', $testApplication->id)
            ->orderBy('id', 'desc')
            ->first();
    }

    public function findAllPreviousApplications($test_application_id)
    {
        $testApplication = $this->model->find($test_application_id);

        return $this->model
            ->where('applicant_id', '=', $testApplication->applicant_id)
            ->where('applicant_type', '=', $testApplication->applicant_type)
            ->where('test_id', '=', $testApplication->test_id)
            ->where('id', '<>', $testApplication->id)
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Resolve function type class
     *
     * @param String $entityName
     * @return String
     */
    private function resolveEntityClassName($entityName)
    {
        return self::CLASS_NAMES[$entityName];
    }

    /**
     * Private function to retrieve needed model relations in order to not to repeat
     * the same code on every query sent
     *
     * @return Array
     */

    private function getModelRelations()
    {
        $locale = app()->getLocale();

        return [
            'answers' => function ($query) use ($locale) {
                $query
                    ->with([
                        'question_responses' => function ($query) use ($locale) {
                            $query->select('id', 'question_test_id', 'response_id','cal_value')
                                ->with([
                                    'question_test' => function ($query) use ($locale) {
                                        $query->select('id', 'question_id')
                                            ->with([
                                                'question' => function ($query) use ($locale) {
                                                    $query->select('id', 'unit_id', 'question_category_code')
                                                        ->withTranslation($locale);
                                                    $query->with(['unit', 'question_category']);
                                                },
                                            ]);
                                    },
                                    'response' => function ($query) use ($locale) {
                                        $query->select('id')
                                            ->withTranslation($locale);
                                    }
                                ]);
                        }
                    ]);
            },

        ];
    }
}
