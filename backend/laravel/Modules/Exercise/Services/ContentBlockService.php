<?php

namespace Modules\Exercise\Services;

use Exception;
use App\Traits\ResponseTrait;

// Repositores
use Modules\Exercise\Repositories\Interfaces\ExerciseContentBlockRepositoryInterface;

// Entities
use Modules\Exercise\Entities\ExerciseContentBlock;

class ContentBlockService 
{
    use ResponseTrait;

    /**
     * @var object $contentBlockRepository
     */
    protected $contentBlockRepository;

    /**
     * Create a new service instance
     */
    public function __construct(
        ExerciseContentBlockRepositoryInterface $contentBlockRepository,
    ) {
        $this->contentBlockRepository = $contentBlockRepository;
    }

    /**
     * Retrieves a translated list of all daily control items
     * @return ExerciseContentBlock[]
     * 
     * @OA\Schema(
     *  schema="ListExerciseContentBlockResponse",
     *  type="object",
     *  description="Retrieves a translated list of all exercise content blocks",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Exercise Content Blocks"),
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
        return $this->contentBlockRepository->findAllTranslated();
    }

    /**
     * 
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

            return $this->contentBlockRepository->create($itemData);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * 
     */
    public function show(ExerciseContentBlock $educationLevel)
    {
        return $educationLevel;
    }

    /**
     * 
     */
    public function update($requestData, ExerciseContentBlock $educationLevel)
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

            $this->contentBlockRepository->update($itemData, $educationLevel);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * 
     */
    public function destroy(ExerciseContentBlock $educationLevel)
    {
        try {
            return $this->contentBlockRepository->delete($educationLevel->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
