<?php

namespace Modules\Player\Services;

use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Modules\Generality\Services\ResourceService;
use Modules\Player\Repositories\Interfaces\PlayerTrajectoryRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Exception;

class PlayerTrajectoryService 
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var $playerTrajectoryRepository
     */
    protected $playerTrajectoryRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * Create a new service instance
     */
    public function __construct(
        PlayerTrajectoryRepositoryInterface $playerTrajectoryRepository,
        ResourceRepositoryInterface $resourceRepository,
        ResourceService $resourceService
    ) {
        $this->playerTrajectoryRepository = $playerTrajectoryRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
    }

    /**
     * Inserts a new player trajectory row into the database
     */
    public function insertPlayerTrajectory ($trajectory_data)
    {
        try {
            if (isset($trajectory_data['image'])) {
                $dataResource = $this->uploadResource('/player_trajectory', $trajectory_data['image']);
    
                $resource = $this->resourceRepository->create($dataResource);
    
                if ($resource) {
                    $trajectory_data['image_id'] = $resource->id;
                    unset($trajectory_data['image']);
                }
            }
    
            return $this->playerTrajectoryRepository->create($trajectory_data);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function updatePlayerTrajectory ($trajectory_data, $trajectory_id)
    {
        try {
            $trajectory = $this->playerTrajectoryRepository->findOneBy([
                'id' => $trajectory_id
            ]);

            $deletableImageId = null;

            if ($trajectory_data['image']) {
                $dataResource = $this->uploadResource('/player_trajectory', $trajectory_data['image']);

                $resource = $this->resourceRepository->create($dataResource);

                $trajectory_data['image_id'] = $resource->id;

                $deletableImageId = $trajectory->image_id;
            }

            $updated = $this->playerTrajectoryRepository->update($trajectory_data, $trajectory);

            if ($deletableImageId) {
                $this->resourceService->deleteResourceData($deletableImageId);
            }

            return $updated;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}