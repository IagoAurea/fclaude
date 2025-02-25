<?php

namespace Modules\Training\Services;

use Carbon\Carbon;
use Modules\Alumn\Entities\Alumn;
use Modules\Player\Entities\Player;
use Modules\Training\Repositories\Interfaces\TrainingLoadRepositoryInterface;
use Modules\Training\Repositories\Interfaces\ExerciseSessionAssistanceRepositoryInterface;

class TrainingLoadService
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
     * Creates a new service instance
     */
    public function __construct(
        ExerciseSessionAssistanceRepositoryInterface $exerciseSessionAssistanceRepository,
        TrainingLoadRepositoryInterface $trainingLoadRepository
    )
    {
        $this->exerciseSessionAssistanceRepository = $exerciseSessionAssistanceRepository;
        $this->trainingLoadRepository = $trainingLoadRepository;
    }

    public function trainingLoadActual($entity, $id)
    {
        $today = Carbon::now()->format('Y-m-d');

        $training = $this->trainingLoadRepository->findOneByRangeDate($entity, $id, $today);
            
        return $training->value ?? "N/A";
    }

    /**
     * Find all register of entity assistance with training
     */
    public function trainingLoadByEntity($entity, $id)
    {
        $class_entity = $entity == 'player' ? Player::class : Alumn::class;

        return $this->exerciseSessionAssistanceRepository->findAllTraining($class_entity, $id);
    }

    /**
     * Retrieve all training load average by entity
     */
    public function trainingLoadsByPeriodAndEntity($entity, $id)
    {
        $class_entity = $entity == 'player' ? Player::class : Alumn::class;

        return $this->trainingLoadRepository->findBy([
            'entity_type' => $class_entity,
            'entity_id' => $id
        ]);
    }
}