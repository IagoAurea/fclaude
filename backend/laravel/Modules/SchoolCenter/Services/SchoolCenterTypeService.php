<?php

namespace Modules\SchoolCenter\Services;

use App\Traits\ResponseTrait;
use Exception;

// Repositories
use Modules\Club\Repositories\Interfaces\SchoolCenterTypeRepositoryInterface;

class SchoolCenterTypeService
{
    use ResponseTrait;

    /**
     * @var object $schoolCenterTypeRepository
     */
    protected $schoolCenterTypeRepository;

    /**
     * Creates a new service instance
     */
    public function __construct(
        SchoolCenterTypeRepositoryInterface $schoolCenterTypeRepository
    ) {
        $this->schoolCenterTypeRepository = $schoolCenterTypeRepository;
    }

    /**
     * Returns some school data with all the related academic years information
     * @return Array
     * 
     * @OA\Schema(
     *  schema="ListSchoolCenterTypeResponse",
     *  type="object",
     *  description="Returns the list of related school center types",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="School center type list"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="code", type="string", example="string"),
     *          @OA\Property(property="name", type="string", example="string"),
     *      ),
     *  ),
     * )
     */
    public function index()
    {
        try {
            return $this->schoolCenterTypeRepository->findAllTranslated();
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
