<?php

namespace Modules\Classroom\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Exception;

// Repositories
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseRepositoryInterface;
use Modules\Training\Repositories\Interfaces\TrainingPeriodRepositoryInterface;
use Modules\Training\Repositories\Interfaces\TypeExerciseSessionRepositoryInterface;
use Modules\Training\Repositories\Interfaces\TargetSessionRepositoryInterface;

// Services
use Modules\Training\Services\ExerciseSessionService;

class ClassroomExerciseSessionTableSeeder extends Seeder
{
    const MAX_SESSIONS = 5;

    /**
     * @var object
     */
    protected $classroomRepository;

    /**
     * @var object
     */
    protected $exerciseRepository;

    /**
     * @var object
     */
    protected $trainingPeriodRepository;

    /**
     * @var object
     */
    protected $typeExerciseRepository;

    /**
     * @var object
     */
    protected $targetRepository;

    /**
     * @var object
     */
    protected $sessionService;

    /**
     * @var object
     */
    protected $faker;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        ClassroomRepositoryInterface $classroomRepository,
        ExerciseRepositoryInterface $exerciseRepository,
        TrainingPeriodRepositoryInterface $trainingPeriodRepository,
        TypeExerciseSessionRepositoryInterface $typeExerciseRepository,
        TargetSessionRepositoryInterface $targetRepository,
        ExerciseSessionService $sessionService
    ) {
        $this->classroomRepository = $classroomRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->trainingPeriodRepository = $trainingPeriodRepository;
        $this->typeExerciseRepository = $typeExerciseRepository;
        $this->targetRepository = $targetRepository;
        $this->sessionService = $sessionService;
        $this->faker = Factory::create();
    }

    /**
     * 
     */
    private function getSessionData($period, $typeExercise)
    {
        return [
            'author' => $this->faker->name,
            'title' => $this->faker->words(2, true),
            'icon' => $this->faker->url,
            'difficulty' => $this->faker->randomDigitNotNull,
            'intensity' => $this->faker->randomDigitNotNull,
            'duration' =>  $this->faker->time('H:i'),
            'number_exercises' => $this->faker->randomDigitNotNull,
            'type_exercise_session_id' => $typeExercise->id,
            'training_period_id' => $period->id,
            'materials' => $this->faker->lexify('material_?????_?????'),
        ];
    }

    /**
     * 
     */
    private function getExercisesData($exercises)
    {
        $exerciseList = [];
        $randExercises = $exercises->random(
            $this->faker->numberBetween(1, 3)
        )->toArray();

        foreach ($randExercises as $randExercise) {
            $exerciseList[] = [
                'exercise_id' => $randExercise['id'],
                'duration' => $this->faker->time('H:i'),
                'repetitions' => $this->faker->randomDigitNotNull,
                'duration_repetitions' => $this->faker->time('H:i'),
                'break_repetitions' => $this->faker->time('H:i'),
                'series' => $this->faker->randomDigitNotNull,
                'break_series' => $this->faker->time('H:i'),
            ];
        }

        return $exerciseList;
    }

    /**
     * 
     */
    private function getExecutionData()
    {
        $date = Carbon::parse(
            $this->faker->dateTimeThisMonth()
        )->format('Y-m-d');

        return [
            'date_session' => $date,
            'hour_session' => $this->faker->time('H:i'),
            'place_session' => $this->faker->address,
            'observation' => $this->faker->sentence,
        ];
    }

    /**
     * 
     */
    private function getTargetsData($target)
    {
        return [$target->id];
    }

    /**
     * @return void
     */
    protected function createExerciseSessions()
    {
        try {
            $classrooms = $this->classroomRepository->findAll();
            $exercises = $this->exerciseRepository->findAll();
            $trainingPeriods = $this->trainingPeriodRepository->findAll();
            $typeExercises = $this->typeExerciseRepository->findAll();
            $targets = $this->targetRepository->findAll();
            
            foreach ($classrooms as $classroom) {
                for ($i = 0; $i <  self::MAX_SESSIONS; $i ++ ) {
                    $period = $trainingPeriods->random();
                    $typeExercise = $typeExercises->random();
                    $target = $targets->random();
        
                    // Perform individual creation methods
                    $sessionData = $this->getSessionData($period, $typeExercise);
                    $exercisesData = $this->getExercisesData($exercises);
                    $executionData = $this->getExecutionData();
                    $targetsData = $this->getTargetsData($target);
        
                    $this->sessionService->store(
                        $classroom, $sessionData, $exercisesData, $executionData, $targetsData
                    );
                }
            }
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createExerciseSessions();
    }
}
