<?php

namespace Modules\Exercise\Services;

use Exception;
use App\Traits\ResponseTrait;

// Repositores
use Modules\Exercise\Repositories\Interfaces\ExerciseEducationLevelRepositoryInterface;

// Entities
use Modules\Exercise\Entities\ExerciseEducationLevel;

class EducationLevelService 
{
    use ResponseTrait;

    /**
     * @var object $educationLevelRepository
     */
    protected $educationLevelRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        ExerciseEducationLevelRepositoryInterface $educationLevelRepository,
    ) {
        $this->educationLevelRepository = $educationLevelRepository;
    }

    /**
     * Retrieves a translated list of all daily control items
     * @return ExerciseEducationLevel[]
     * 
     * @OA\Schema(
     *  schema="ListExerciseEducationLevelResponse",
     *  type="object",
     *  description="Retrieves a translated list of all exercise education levels",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise Education Levels"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(
     *              property="id",
     *              format="int64",
     *              example="1",
     *          ),
     *          @OA\Property(
     *              property="code",
     *              format="string",
     *          ),
     *          @OA\Property(
     *              property="name",
     *              format="string",
     *          ),
     *      ),
     *  ),
     * )
     */
    public function index()
    {
        return $this->educationLevelRepository->findAllTranslated();
    }

    /**
     * Stores a new daily control item into the database
     * @return DailyControlItem
     */
    public function store($requestData)
    {
        try {
            $itemData = [
                'es' => [
                    'name' => $requestData['es']
                ],
                'en' => [
                    'name' => $requestData['en']
                ],
                'code' => $requestData['code'],
            ];

            return $this->educationLevelRepository->create($itemData);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * 
     */
    public function show(ExerciseEducationLevel $educationLevel)
    {
        return $educationLevel;
    }

    /**
     * 
     */
    public function update($requestData, ExerciseEducationLevel $educationLevel)
    {
        try {
            $itemData = [
                'es' => [
                    'name' => $requestData['es']
                ],
                'en' => [
                    'name' => $requestData['en']
                ],
                'code' => $requestData['code'],
            ];

            $this->educationLevelRepository->update($itemData, $educationLevel);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * 
     */
    public function destroy(ExerciseEducationLevel $educationLevel)
    {
        try {
            return $this->educationLevelRepository->delete($educationLevel->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
