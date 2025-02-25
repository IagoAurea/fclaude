<?php

namespace Modules\Club\Services;

use App\Traits\ResponseTrait;
use Modules\Club\Repositories\Interfaces\SchoolCenterTypeRepositoryInterface;
use Exception;

class SchoolCenterTypeService 
{
    use ResponseTrait;

    /**
     * Instances a new controller class.
     */
    protected $typeRepository;

    /**
     * Creates a new service instance
     */
    public function __construct(SchoolCenterTypeRepositoryInterface $typeRepository) 
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * Returns a translated list of all school type items
     * 
     * @return array
     */
    public function list()
    {
        try {
            return $this->typeRepository->findAllTranslated();
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
