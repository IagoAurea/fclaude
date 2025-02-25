<?php

namespace Modules\Exercise\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

// Repositories
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\DistributionExerciseRepositoryInterface;
use Modules\Exercise\Repositories\Interfaces\ContentExerciseRepositoryInterface;

// Services
use Modules\Exercise\Services\ExerciseService;

class ExercisesTableSeeder extends Seeder
{
    const NUMBER = 5;

    /**
     * @var object
     */
    protected $teamRepository;

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
    protected $faker;

    public function __construct(
        TeamRepositoryInterface $teamRepository,
        ClubRepositoryInterface $clubRepository,
        DistributionExerciseRepositoryInterface $distributionRepository,
        ContentExerciseRepositoryInterface $contentExerciseRepository,
        ExerciseService $exerciseService
    ) {
        $this->teamRepository = $teamRepository;
        $this->clubRepository = $clubRepository;
        $this->distributionRepository = $distributionRepository;
        $this->contentExerciseRepository = $contentExerciseRepository;
        $this->exerciseService = $exerciseService;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createExercises(array $elements)
    {
        $distributions = $this->distributionRepository->findAll();

        foreach($elements as $element){
            $clubs = $this->clubRepository->findByOwner($element);

            foreach($clubs as $club) {
                $team = $this->teamRepository->findOneBy(['club_id' => $club->id]);

                for ($i = 0; $i < self::NUMBER; $i++) {
                    $distribution = $distributions->shuffle()->first();

                    $exerciseData = [
                        'title' => 'Exercise '.ucfirst($this->faker->name),
                        'description' => ucfirst($this->faker->text($maxNbChars = 200)),
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
                    ];

                    $this->exerciseService->store(
                        $exerciseData, $club->user_id, $team
                    );
                }
            }
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'user_55sy6csdmp@gmail.com'
            ],
            [
                'teach_mod7ra6j3q@gmail.com'
            ],
            [
                'cliente@fisicalcoach.com'
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createExercises($this->get()->current());
    }
}
