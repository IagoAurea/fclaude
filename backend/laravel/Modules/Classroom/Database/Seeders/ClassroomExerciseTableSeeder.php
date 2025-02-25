<?php

namespace Modules\Classroom\Database\Seeders;

use Faker\Factory;
use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;

// Repositories
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\DistributionExerciseRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ContentExerciseRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ExerciseEducationLevelRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

// Services
use Modules\Exercise\Services\ExerciseService;

class ClassroomExerciseTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    const NUMBER = 2;

    /**
     * @var object
     */
    protected $classroomRepository;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $distributionRepository;

    /**
     * @var object
     */
    protected $exerciseService;

    /**
     * @var object
     */
    protected $contentExerciseRepository;

    /**
     * @var object
     */
    protected $educationLevelRepository;

    /**
     * @var object
     */
    protected $resourceRepository;

    /**
     * @var object
     */
    protected $faker;

    public function __construct(
        ClassroomRepositoryInterface $classroomRepository,
        ClubRepositoryInterface $clubRepository,
        DistributionExerciseRepositoryInterface $distributionRepository,
        ContentExerciseRepositoryInterface $contentExerciseRepository,
        ExerciseEducationLevelRepositoryInterface $educationLevelRepository,
        ResourceRepositoryInterface $resourceRepository,
        ExerciseService $exerciseService
    ) {
        $this->classroomRepository = $classroomRepository;
        $this->clubRepository = $clubRepository;
        $this->distributionRepository = $distributionRepository;
        $this->contentExerciseRepository = $contentExerciseRepository;
        $this->educationLevelRepository = $educationLevelRepository;
        $this->resourceRepository = $resourceRepository;
        $this->exerciseService = $exerciseService;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createClassroomExercises()
    {
        $distributions = $this->distributionRepository->findAll();
        $educationLevels = $this->educationLevelRepository->findAll();
        $classrooms = $this->classroomRepository->findAll();

        foreach($classrooms as $classroom) {
            for ($i = 0; $i < self::NUMBER; $i++) {
                $distribution = $distributions->shuffle()->first();
                $educationLevel = $educationLevels->shuffle()->first();

                $exerciseData = [
                    'title' => 'Exercise '.ucfirst($this->faker->name),
                    'description' => ucfirst($this->faker->text(200)),
                    'favorite' => $this->faker->boolean(),
                    'dimentions' => 'Dimentions ' . $this->faker->regexify('[1-9]{3}X[1-9]{3}'),
                    'duration' => $this->faker->regexify('[0-9]{2}:[0-9]{2}'),
                    'repetitions' => $this->faker->randomDigit(),
                    'duration_repetitions' => $this->faker->regexify('[0-9]{2}:[0-9]{2}'),
                    'break_repetitions' => $this->faker->regexify('[0-9]{2}:[0-9]{2}'),
                    'series' => $this->faker->randomDigit(),
                    'break_series' => $this->faker->regexify('[0-9]{2}:[0-9]{2}'),
                    'difficulty' => $this->faker->randomDigit(),
                    'intensity' => $this->faker->randomDigit(),
                    'distribution_exercise_id' => $distribution->id,
                    'exercise_education_level_id' => $educationLevel->id,
                ];

                $this->exerciseService->store(
                    $exerciseData, $classroom->club->owner->id, $classroom
                );
            }
        }
        
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createClassroomExercises();
    }
}
