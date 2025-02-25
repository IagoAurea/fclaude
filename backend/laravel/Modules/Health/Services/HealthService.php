<?php

namespace Modules\Health\Services;

use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;

// External Entities
use Modules\Player\Entities\Player;
use Modules\Health\Entities\Disease;
use Modules\Health\Entities\Allergy;
use Modules\Health\Entities\AreaBody;
use Modules\Health\Entities\PhysicalProblem;
use Modules\Health\Entities\TypeMedicine;
use Modules\Health\Entities\TobaccoConsumption;
use Modules\Health\Entities\AlcoholConsumption;

// Repositories
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Health\Repositories\Interfaces\HealthRepositoryInterface;

class HealthService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $healthRepository
     */
    protected $healthRepository;

    /**
     * @var $helper
     */
    protected $helper;

    /**
     * Create a new service instance
     */
    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        HealthRepositoryInterface $healthRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->healthRepository = $healthRepository;
    }

    /**
     * Inserts or updates data related to the health relationships
     *
     * @return void
     */
    public function updateHealthStatus($entity, $request_data)
    {
        foreach ($request_data as $key => $values) {
            $health_class = $this->resolveHealthClass($key);

            $this->healthRepository->bulkDeleteRelations($entity, $health_class);

            // Check if the items sent are iterable as an array
            if (is_array($values)) {
                foreach ($values as $health_value) {
                    $this->insertHealthRelation($entity, $health_class, $health_value);
                }
                
                // Otherwise is an individual item sent as alcohol or tobacco consumption
            } else {
                if (isset($values)) {
                    $this->insertHealthRelation($entity, $health_class, $values);
                }
            }
        }
    }

    /**
     * Does an insertion to the relational table between player and health status
     *
     * @param int $player_id
     * @param string $class
     * @param int $value
     * @return void
     */
    private function insertHealthRelation($entity, $class, $value)
    {
        $this->healthRepository->create([
            'entity_id' => $entity->id,
            'entity_type' => get_class($entity),
            'health_entity_type' => $class,
            'health_entity_id' => $value,
        ]);
    }

    /**
     * Used to return the relationship insertion class depending on the
     * key value sent
     *
     * @param String $key
     * @return String
     */
    private function resolveHealthClass($key)
    {
        $classes = [
            'diseases' => Disease::class,
            'allergies' => Allergy::class,
            'body_areas' => AreaBody::class,
            'physical_problems' => PhysicalProblem::class,
            'medicine_types' => TypeMedicine::class,
            'tobacco_consumptions' => TobaccoConsumption::class,
            'alcohol_consumptions' => AlcoholConsumption::class,
        ];

        return $classes[$key];
    }
}
