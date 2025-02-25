<?php

namespace Modules\Health\Services;

use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Health\Repositories\Interfaces\SurgeryRepositoryInterface;

class SurgeryService 
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $surgeryRepository
     */
    protected $surgeryRepository;

    /**
     * @var $helper
     */
    protected $helper;

    /**
     * Create a new service instance
     */
    public function __construct(
        PlayerRepositoryInterface $playerRepository,
        SurgeryRepositoryInterface $surgeryRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->surgeryRepository = $surgeryRepository;
    }

    /**
     * Inserts or updates data related to the health relationships
     *
     * @return void
     */
    public function manageSurgeries($entity, $surgeries)
    {
        $this->surgeryRepository->bulkDelete([
            'entity_id' => $entity->id,
        ]);

        foreach ($surgeries as $surgery) {
            $this->surgeryRepository->create([
                'entity_id' => $entity->id,
                'entity_type' => get_class($entity),
                'disease_id' => $surgery['disease_id'],
                'surgery_date' => $surgery['surgery_date']
            ]);
        }
    }
}
