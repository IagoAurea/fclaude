<?php

namespace Modules\Training\Services;

use App\Helpers\Helper;
use Modules\Training\Repositories\Interfaces\TrainingLoadRepositoryInterface;
use Modules\Training\Repositories\Interfaces\ExerciseSessionAssistanceRepositoryInterface;

class ExerciseSessionAssistanceService
{
    /**
     * @var object $trainingLoadRepository
     */
    protected $trainingLoadRepository;

    /**
     * @var object $exerciseSessionAssistanceRepository
     */
    protected $exerciseSessionAssistanceRepository;

    /**
     * @var helper
     */
    protected $helper;

     /**
     * Creates a new service instance
     */
    public function __construct(
        TrainingLoadRepositoryInterface $trainingLoadRepository,
        ExerciseSessionAssistanceRepositoryInterface $exerciseSessionAssistanceRepository,
        Helper $helper
    )
    {
        $this->trainingLoadRepository = $trainingLoadRepository;
        $this->exerciseSessionAssistanceRepository = $exerciseSessionAssistanceRepository;
        $this->helper = $helper;
    }

    public function calculateTrainingLoad($entity, $id, $start, $end)
    {
        $trainings = $this->exerciseSessionAssistanceRepository->findAllTraining($entity, $id, $start, $end);

        $number_training = 0;
        $total_perception_effort = 0;
        $times_training = [];
        $ids_training = [];

        foreach ($trainings as $training) {
            array_push($ids_training, $training->id);

            if ($training->perception_effort) {
                $total_perception_effort = $total_perception_effort + $training->perception_effort->number;
                $number_training++;
                array_push($times_training, $training->time_training);
            }
        }

        $average_perception = intval($number_training) > 0 ? $total_perception_effort / $number_training : 0;

        $total_time_training = $this->helper->sumTimeHoursMinutes($times_training);

        $total_training = intval($total_time_training) * $average_perception;

        $data_training = [
            'entity_type' => $entity,
            'entity_id' => $id,
            'from' => $start,
            'to' => $end
        ];

        $training_load = $this->trainingLoadRepository->updateOrCreate($data_training, [
            'value' => $total_training,
            'period' => 'week'
        ]);

        $training_load->exercise_session_assistance()->detach($ids_training);

        $training_load->exercise_session_assistance()->attach($ids_training);
    }
}