<?php

namespace Modules\Generality\Services;

use App\Traits\ResourceTrait;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Exception;

class ResourceService
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $resourceRepository;

    public function __construct(ResourceRepositoryInterface $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * Delete resource data
     * @param int $resource
     * @return void
     */

    public function deleteResourceData($resource)
    {
        $resourceDelete = $this->resourceRepository->findOneBy(['id' => $resource]);

        $this->deleteResource($resourceDelete->url);

        $resourceDelete->delete();
    }

    /**
     * Stores an image resource
     */
    public function store($path, $image)
    {
        try {
            if (isset($image)) {
                $dataResource = $this->uploadResource($path, $image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    return $resource;
                }
            }

            return NULL;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}