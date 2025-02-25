<?php

namespace Modules\AlumnControl\Services;

use Exception;
use Illuminate\Http\Response;
use App\Traits\ResponseTrait;
use App\Traits\TranslationTrait;
use Modules\Alumn\Entities\Alumn;
use Modules\Classroom\Entities\Classroom;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\AlumnControl\Services\DailyControlItemService;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class DailyControlService
{
    use ResponseTrait, TranslationTrait;

    /**
     * @var object $dailyControlRepository
     */
    protected $dailyControlRepository;

    /**
     * @var object $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;

    /**
     * @var object $classroomRepository
     */
    protected $classroomRepository;

    /**
     * @var object $controlItemService
     */
    protected $controlItemService;

    /**
     * Create a new service instance
     */
    public function __construct(
        DailyControlRepositoryInterface $dailyControlRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository,
        ClassroomRepositoryInterface $classroomRepository,
        DailyControlItemService $controlItemService
    ) {
        $this->dailyControlRepository = $dailyControlRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $this->classroomRepository = $classroomRepository;
        $this->controlItemService = $controlItemService;
    }

    /**
     * Returns the list of all alumns belonging to the classroom year with all their daily control items
     * @return Array
     *
     * @OA\Schema(
     *  schema="DailyControlAlumnListResponse",
     *  type="object",
     *  description="Returns a list of all daily control alumns related to a classroom",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List of all alumns with daily control items"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="int64", example="1"),
     *          @OA\Property(property="name", type="string", example="string"),
     *          @OA\Property(property="image", type="string", example="string"),
     *          @OA\Property(property="gender", type="string", example="string"),
     *          @OA\Property(property="list_number", type="string", example="string"),
     *          @OA\Property(
     *              property="control_items",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="int64", example="1"),
     *                  @OA\Property(property="alumn_id", type="int64", example="1"),
     *                  @OA\Property(property="daily_control_item_id", type="int64", example="1"),
     *                  @OA\Property(property="academic_period_id", type="int64", example="1"),
     *                  @OA\Property(property="count", type="int64", example="1"),
     *                  @OA\Property(property="control_name", type="string", example="string"),
     *                  @OA\Property(property="updated_at", type="date-time", example="2020-01-01 00:00:00"),
     *              )
     *          ),
     *      ),
     *  ),
     * )
     */
    public function list($requestData, Classroom $classroom)
    {
        $data = [];

        $configItems = $this->getTimelapseItems($requestData, $classroom, true, false);

        $date = $requestData['date'] ?? null;

        foreach ($configItems['classroom_year']->alumns as $alumn) {
            $dailyControlItems = $this->dailyControlRepository->findAlumnItems(
                $alumn->id,
                $configItems['classroom_academic_year_id'],
                $configItems['academic_period_id'],
                $date
            );

            $data[] = [
                'id' => $alumn->id,
                'name' => $alumn->full_name,
                'image' => $alumn->image,
                'gender' => $alumn->gender['code'],
                'list_number' => $alumn->list_number,
                'control_items' => $dailyControlItems
            ];
        }

        return $data;
    }

    /**
     * Stores a set of daily control items into the database
     * @return void
     *
     * @OA\Schema(
     *  schema="DailyControlAlumnStoreResponse",
     *  type="object",
     *  description="Stores a set of daily control items into the database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Stored alumn daily control"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="null"
     *  ),
     * )
     */
    public function store($requestData, $update = true)
    {
        try {
            $existent = $this->dailyControlRepository->findOneBy([
                'alumn_id' => $requestData['alumn_id'],
                'classroom_academic_year_id' => $requestData['classroom_academic_year_id'],
                'academic_period_id' => $requestData['academic_period_id']
            ]);

            if (!$existent) {
                $this->controlItemService->registerAlumnSet(
                    $requestData['alumn_id'],
                    $requestData['classroom_academic_year_id'],
                    $requestData['academic_period_id']
                );
            }
            
            if($update) {
                $this->handleControlItems($requestData, true);
            }
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }

    /**
     * Returns the list of all alumns belonging to the classroom year with all their daily control items
     * @return Array
     *
     * @OA\Schema(
     *  schema="DailyControlAlumnDetailsResponse",
     *  type="object",
     *  description="Returns a list of all daily control items related to an specific alumn",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Daily Control Data"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="name", type="string", example="string"),
     *      @OA\Property(property="image", type="string", example="string"),
     *      @OA\Property(property="gender", type="string", example="string"),
     *      @OA\Property(property="list_number", type="string", example="string"),
     *      @OA\Property(
     *          property="control_items",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="alumn_id", type="int64", example="1"),
     *              @OA\Property(property="daily_control_item_id", type="int64", example="1"),
     *              @OA\Property(property="academic_period_id", type="int64", example="1"),
     *              @OA\Property(property="count", type="int64", example="1"),
     *              @OA\Property(property="control_name", type="string", example="string"),
     *              @OA\Property(property="updated_at", type="date-time", example="2020-01-01 00:00:00"),
     *          )
     *      ),
     *  ),
     * )
     */
    public function show($requestData, Classroom $classroom, Alumn $alumn)
    {
        $configItems = $this->getTimelapseItems($requestData, $classroom);

        $date = $requestData['date'] ?? null;

        $controlItems = $this->dailyControlRepository->findAlumnItems(
            $alumn->id,
            $configItems['classroom_academic_year_id'],
            $configItems['academic_period_id'],
            $date
        );

        return [
            'id' => $alumn->id,
            'name' => $alumn->full_name,
            'image' => $alumn->image,
            'gender' => $alumn->gender['code'],
            'list_number' => $alumn->list_number,
            'control_items' => $controlItems,
        ];
    }

    /**
     * Updates infomation about already stored daily control items
     * @return void
     *
     * @OA\Schema(
     *  schema="DailyControlAlumnUpdateResponse",
     *  type="object",
     *  description="Updates a set of daily control items into the database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Updated alumn daily control"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="null"
     *  ),
     * )
     */
    public function update($requestData, $classroom)
    {
        try {
            $configItems = $this->getTimelapseItems($requestData, $classroom);

            $handlingData = [
                'classroom_academic_year_id' => $configItems['classroom_academic_year_id'],
                'academic_period_id' => $configItems['academic_period_id'],
                'alumn_id' => $requestData['alumn_id'],
                'control_items' => $requestData['control_items']
            ];

            $updateReset = $requestData['reset'] ?? false;

            return $this->handleControlItems($handlingData, $updateReset);
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }

    /**
     * Resets all the counters from daily control items depending on the
     * configuration sent
     * @return void
     *
     * @OA\Schema(
     *  schema="DailyControlAlumnResetResponse",
     *  type="object",
     *  description="Updates a set of daily control items into the database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Daily control successfully reseted"),
     *  @OA\Property(
     *      property="data",
     *      type="string",
     *      example="null"
     *  ),
     * )
     */
    public function reset($requestData, $classroom)
    {
        try {
            $configItems = $this->getTimelapseItems($requestData, $classroom);

            $this->dailyControlRepository->reset(
                $configItems['classroom_academic_year_id'],
                $configItems['academic_period_id'],
                $requestData['alumn_id'] ?? null,
            );

            return true;
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }

    /**
     * Updates count information about daily control items
     *
     * @return void
     */
    private function handleControlItems($handleData, $updateReset = false)
    {
        $dateReset = now();
        
        foreach ($handleData['control_items'] as $controlItem) {
            $item = $this->dailyControlRepository->findOneBy([
                'alumn_id' => $handleData['alumn_id'],
                'classroom_academic_year_id' => $handleData['classroom_academic_year_id'],
                'academic_period_id' => $handleData['academic_period_id'],
                'daily_control_item_id' => $controlItem['daily_control_item_id'],
            ]);

            if (!$item) {
                throw new ModelNotFoundException;
            }

            $dataUpdate = [
                'count' => $controlItem['count']
            ];

            if ($updateReset) {
                $dataUpdate['reset'] = $dateReset;
            }

            $this->dailyControlRepository->update($dataUpdate, $item);
        }

        return true;
    }

    /**
     * Retrieve and validate year and period academic active
     *
     * @return array
     */
    public function getTimelapseItems($requestData, Classroom $classroom, $return_value = true, $validate_period = true)
    {
        $classroomAcademicYearId = $requestData['classroom_academic_year_id']
            ?? $classroom->activeAcademicYears->first()->classroom_academic_year_id
            ?? null;

        if (!$classroomAcademicYearId) {
            abort(response()->error($this->translator('classroom_not_active_year'),
                Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        $classroomYear = $this->classroomAcademicYearRepository->findOneBy([
            'id' => $classroomAcademicYearId
        ]);

        $academicPeriodId = $requestData['academic_period_id']
            ?? $classroomYear->academicYear->active_academic_period->id
            ?? null;

        if ($validate_period && !$academicPeriodId) {
            abort(response()->error($this->translator('classroom_not_active_period'),
                Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        if ($return_value) {
            return [
                'classroom_academic_year_id' => $classroomAcademicYearId,
                'academic_period_id' => $academicPeriodId,
                'classroom_year' => $classroomYear,
            ];
        }
    }

    /**
     * Generate daily control alumns change period academic
     */
    public function generateDailyControlAlumns($model)
    {
        if(!$model->id) { return; }

        try {
            $classroomAcademicYear = $this->classroomAcademicYearRepository->findOneBy([
                'academic_year_id' => $model->academic_year_id
            ]);
    
            foreach($classroomAcademicYear->alumns as $alumn) {
                $this->store([
                    'alumn_id' => $alumn->id,
                    'classroom_academic_year_id' => $classroomAcademicYear->id,
                    'academic_period_id' => $model->id
                ], false);
            }
        } catch (Exception $exception) {
            \Log::info($exception);
        }
        
    }
}