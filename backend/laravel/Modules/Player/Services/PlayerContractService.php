<?php

namespace Modules\Player\Services;

use App\Traits\ResponseTrait;
use App\Traits\ResourceTrait;
use Modules\Generality\Services\ResourceService;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerContractRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Exception;

class PlayerContractService 
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $playerContractRepository
     */
    protected $playerContractRepository;

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
        PlayerRepositoryInterface $playerRepository,
        PlayerContractRepositoryInterface $playerContractRepository,
        ResourceService $resourceService,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->playerContractRepository = $playerContractRepository;
        $this->resourceService = $resourceService;
        $this->resourceRepository = $resourceRepository;

    }

    /**
     * Inserts a new player contract into the database
     */
    public function insertPlayerContract($contract_data)
    {
        try {
            if (isset($contract_data['image'])) {
                $dataResource = $this->uploadResource('/player_contract', $contract_data['image']);
    
                $resource = $this->resourceRepository->create($dataResource);
    
                if ($resource) {
                    $contract_data['image_id'] = $resource->id;
                    unset($contract_data['image']);
                }
            }
    
            return $this->playerContractRepository->create($contract_data);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    /**
     * Updates an existent player contract into the database
     */
    public function updatePlayerContract($contract_data, $contract_id)
    {
        try {
            $trajectory = $this->playerContractRepository->findOneBy([
                'id' => $contract_id
            ]);

            $deletableImageId = null;

            if ($contract_data['image']) {
                $dataResource = $this->uploadResource('/player_trajectory', $contract_data['image']);

                $resource = $this->resourceRepository->create($dataResource);

                $contract_data['image_id'] = $resource->id;

                $deletableImageId = $trajectory->image_id;
            }

            $updated = $this->playerContractRepository->update($contract_data, $trajectory);

            if ($deletableImageId) {
                $this->resourceService->deleteResourceData($deletableImageId);
            }

            return $updated;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}