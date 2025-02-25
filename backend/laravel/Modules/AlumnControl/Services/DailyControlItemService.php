<?php

namespace Modules\AlumnControl\Services;

use Exception;
use Illuminate\Support\Arr;
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;
use Modules\Generality\Services\ResourceService;
use Modules\AlumnControl\Entities\DailyControlItem;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlRepositoryInterface;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlItemRepositoryInterface;

class DailyControlItemService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var object $dailyControlItemRepository
     */
    protected $dailyControlItemRepository;

    /**
     * @var object $dailyControlRepository
     */
    protected $dailyControlRepository;

    /**
     * @var object $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var object $resourceService
     */
    protected $resourceService;

    /**
     * Create a new service instance
     */
    public function __construct(
        DailyControlItemRepositoryInterface $dailyControlItemRepository,
        DailyControlRepositoryInterface $dailyControlRepository,
        ResourceRepositoryInterface $resourceRepository,
        ResourceService $resourceService
    ) {
        $this->dailyControlItemRepository = $dailyControlItemRepository;
        $this->dailyControlRepository = $dailyControlRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
    }

    /**
     * Retrieves a translated list of all daily control items
     * @return DailyControlItem[]
     *
     * @OA\Schema(
     *  schema="DailyControlItemListResponse",
     *  type="object",
     *  description="Retrieves a translated list of all daily control items",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of all daily control items"),
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
     *              property="image_id",
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
        return array_values(Arr::sort($this->dailyControlItemRepository->findAllTranslated(), function ($value) {
            return $value['order'];
        }));
    }

    /**
     * Stores a new daily control item into the database
     * @return DailyControlItem
     *
     * @OA\Schema(
     *  schema="DailyControlItemStoreResponse",
     *  type="object",
     *  description="New item is stored in database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Stored a new daily control item"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(
     *          property="id",
     *          format="int64",
     *          example="1",
     *      ),
     *      @OA\Property(
     *          property="image_id",
     *          format="int64",
     *          example="1",
     *      ),
     *      @OA\Property(
     *          property="code",
     *          format="string",
     *      ),
     *      @OA\Property(
     *          property="name",
     *          format="string",
     *      ),
     *  ),
     * )
     */
    public function store($requestData, $image = null)
    {
        try {
            $imageId = null;

            if (isset($image)) {
                $dataResource = $this->uploadResource('/teachers/daily-control-items', $image);
                $resource = $this->resourceRepository->create($dataResource);
                if ($resource) {
                    $imageId = $resource->id;
                }
            }

            $itemData = [
                'es' => [
                    'name' => $requestData['es']
                ],
                'en' => [
                    'name' => $requestData['en']
                ],
                'code' => $requestData['code'],
                'image_id' => $imageId,
            ];

            return $this->dailyControlItemRepository->create($itemData);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Returns an specific control item from the database
     * @return DailyControlItem
     *
     * @OA\Schema(
     *  schema="DailyControlItemShowResponse",
     *  type="object",
     *  description="Retrieves a single daily control item",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Daily control item"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(
     *          property="id",
     *          format="int64",
     *          example="1",
     *      ),
     *      @OA\Property(
     *          property="image_id",
     *          format="int64",
     *          example="1",
     *      ),
     *      @OA\Property(
     *          property="code",
     *          format="string",
     *      ),
     *      @OA\Property(
     *          property="name",
     *          format="string",
     *      ),
     *      @OA\Property(
     *          property="image",
     *          type="object",
     *          @OA\Property(
     *              property="id",
     *              format="int64",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="url",
     *              format="string",
     *          ),
     *          @OA\Property(
     *              property="mime_type",
     *              format="string",
     *          ),
     *          @OA\Property(
     *              property="size",
     *              format="int64",
     *              example="1",
     *          ),
     *      ),
     *  ),
     * )
     */
    public function show(DailyControlItem $item)
    {
        $item->image;
        
        return $item;
    }

    /**
     * Updates an existing item from daily control
     * @return DailyControlItem
     *
     * @OA\Schema(
     *  schema="DailyControlItemUpdateResponse",
     *  type="object",
     *  description="Existent item is updated in database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Updated daily control item"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="null"
     *  ),
     * )
     */
    public function update(DailyControlItem $dailyControlItem, $requestData, $image = null)
    {
        try {
            $imageId = null;
            $deletableImageId = null;

            if (isset($image)) {
                $dataResource = $this->uploadResource('/teachers/daily-control-items', $image);
                $resource = $this->resourceRepository->create($dataResource);
                
                if ($resource) {
                    $imageId = $resource->id;
                    $deletableImageId = $dailyControlItem->image_id;
                }
            }

            $itemData = [
                'es' => [
                    'name' => $requestData['es']
                ],
                'en' => [
                    'name' => $requestData['en']
                ],
                'code' => $requestData['code'],
                'image_id' => $imageId,
            ];

            $this->dailyControlItemRepository->update($itemData, $dailyControlItem);

            if ($deletableImageId) {
                $this->resourceService->deleteResourceData($deletableImageId);
            }

            return null;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deletes an existing item from daily control
     * @return DailyControlItem
     *
     * @OA\Schema(
     *  schema="DailyControlItemDeleteResponse",
     *  type="object",
     *  description="Existent item is updated in database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Deleted daily control item"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="null"
     *  ),
     * )
     */
    public function destroy(DailyControlItem $dailyControlItem)
    {
        try {
            return $this->dailyControlItemRepository->delete($dailyControlItem->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Store a set of new rows when inserting a classroom academic year model
     *
     * @return void
     */
    public function registerAlumnSet($alumnId, $classroomAcademicYearId, $academicPeriodId)
    {
        $items = $this->dailyControlItemRepository->findAll();

        $dateReset = now();

        foreach ($items as $item) {
            $this->dailyControlRepository->create([
                'alumn_id' => $alumnId,
                'daily_control_item_id' => $item->id,
                'classroom_academic_year_id' => $classroomAcademicYearId,
                'academic_period_id' => $academicPeriodId,
                'reset_at' => $dateReset
            ]);
        }
    }
}