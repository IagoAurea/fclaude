<?php

namespace Modules\Training\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Training\Services\ExerciseSessionService;
use Modules\Training\Repositories\Interfaces\ExerciseSessionRepositoryInterface;
use Modules\Training\Repositories\Interfaces\ExerciseSessionExerciseRepositoryInterface;

class ExerciseSessionExerciseService
{
     /**
     * @var object $exerciseSessionRepository
     */
    protected $exerciseSessionExerciseRepository;

    /**
     * @var object $exerciseSessionRepository
     */
    protected $exerciseSessionRepository;

    /**
     * @var object $exerciseSessionService
     */
    protected $exerciseSessionService;

    /**
     * Creates a new service instance
     */
    public function __construct(
        ExerciseSessionRepositoryInterface $exerciseSessionRepository,
        ExerciseSessionExerciseRepositoryInterface $exerciseSessionExerciseRepository,
        ExerciseSessionService $exerciseSessionService
    )
    {
        $this->exerciseSessionRepository = $exerciseSessionRepository;
        $this->exerciseSessionExerciseRepository = $exerciseSessionExerciseRepository;
        $this->exerciseSessionService = $exerciseSessionService;
    }

    public function updateOrderExercises($exercise_session_id, $request)
    {
        foreach ($request->exercises as $exercise) {
            $this->exerciseSessionExerciseRepository->update(
                ['order' => $exercise['order']],
                ['id' => $exercise['id'], 'exercise_session_id' => $exercise_session_id],
                true
            );
        }
    }

    public function createExerciseSessionExercise($request)
    {
        DB::beginTransaction();

        try {
            foreach ($request->exercises as $exercise) {
                $exercise['exercise_session_id'] =  $request->exercise_session_id;

                $exerciseSessionExercise = $this->exerciseSessionExerciseRepository->create($exercise);
                
                $exerciseSessionExercise->work_groups()->sync($exercise['work_groups']);
            }
            
            $this->exerciseSessionService
                ->updateDurationIntensityDifficultyExerciseSession($request->exercise_session_id);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            
            return $exception;
        }

        
        return $exerciseSessionExercise;
    }

    

}