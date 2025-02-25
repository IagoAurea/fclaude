<?php

namespace Modules\SchoolCenter\Services;

use Exception;
use App\Traits\ResponseTrait;
use Modules\Club\Entities\AcademicYear;
use Modules\AlumnControl\Services\DailyControlService;
use Modules\Club\Repositories\Interfaces\AcademicYearRepositoryInterface;
use Modules\Club\Repositories\Interfaces\AcademicPeriodRepositoryInterface;

class SchoolAcademicYearService
{
    use ResponseTrait;

    /**
     * @var object $academicYearRepository
     */
    protected $academicYearRepository;

    /**
     * @var object $academicPeriodRepository
     */
    protected $academicPeriodRepository;

    /**
     * @var object $dailyControlService
     */
    protected $dailyControlService;

    /**
     * Creates a new service instance
     */
    public function __construct(
        AcademicYearRepositoryInterface $academicYearRepository,
        AcademicPeriodRepositoryInterface $academicPeriodRepository,
        DailyControlService $dailyControlService
    ) {
        $this->academicYearRepository = $academicYearRepository;
        $this->academicPeriodRepository = $academicPeriodRepository;
        $this->dailyControlService = $dailyControlService;
    }

    /**
     * Returns some school data with all the related academic years information
     * @return Array
     * 
     * @OA\Schema(
     *  schema="SchoolAcademicYearsListReponse",
     *  type="object",
     *  description="Returns the list of related school academic years",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="List School Academic Years"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(property="id", type="int64", example="1"),
     *      @OA\Property(property="name", type="string", example="string"),
     *      @OA\Property(property="slug", type="string", example="string"),
     *      @OA\Property(property="webpage", type="string", example="string"),
     *      @OA\Property(property="email", type="string", example="string"),
     *      @OA\Property(
     *          property="academic_years",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="id", type="int64", example="1"),
     *              @OA\Property(property="club_id", type="int64", example="1"),
     *              @OA\Property(property="title", type="string", example="string"),
     *              @OA\Property(property="start_date", type="string", example="string"),
     *              @OA\Property(property="end_date", type="string", example="string"),
     *              @OA\Property(property="is_active", type="boolean", example="false"),
     *              @OA\Property(
     *                  property="academic_periods", 
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="int64", example="1"),
     *                      @OA\Property(property="title", type="string", example="string"),
     *                      @OA\Property(property="academic_year_id", type="int64", example="1"),
     *                      @OA\Property(property="start_date", type="string", example="string"),
     *                      @OA\Property(property="end_date", type="string", example="string"),
     *                  )
     *              ),
     *          )
     *      ),
     *  ),
     * )
     */
    public function list($school)
    {
        return [
            'id' => $school->id,
            'name' => $school->name,
            'slug' => $school->slug,
            'webpage' => $school->webpage,
            'email' => $school->email,
            'academic_years' => $school->academicYears,
        ];
    }

    /**
     * Stores a set of academical year items and relates it to a school
     * @return Array
     * 
     * @OA\Schema(
     *  schema="StoreSchoolAcademicYearsResponse",
     *  type="object",
     *  description="Returns the list of all classroom stored academic years",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Classroom academical years"),
     *  @OA\Property(
     *      property="data",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="start_date", format="date", example="2020-01-01"),
     *          @OA\Property(property="end_date", format="date", example="2020-01-01"),
     *          @OA\Property(property="id", format="int64", example="1"),
     *          @OA\Property(property="club_id", format="int64", example="1"),
     *          @OA\Property(
     *              property="academic_periods",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="start_date", format="date", example="2020-01-01"),
     *                  @OA\Property(property="end_date", format="date", example="2020-01-01"),
     *                  @OA\Property(property="id", format="int64", example="1"),
     *                  @OA\Property(property="academic_year_id", format="int64", example="1"),
     *              )
     *          )
     *      ),
     *  ),
     * )
     */
    public function storeAcademicYears($school, $academicYears)
    {
        try {
            $relatedData = [];

            foreach ($academicYears as $academicYear) {
                if(isset($academicYear['is_active']) && $academicYear['is_active']) {
                    $this->desactivateAcademicYears($school->id);
                }

                $storedYear = $this->academicYearRepository->create([
                    'title' => $academicYear['title'] ?? null,
                    'start_date' => $academicYear['start_date'],
                    'end_date' => $academicYear['end_date'],
                    'is_active' => $academicYear['is_active'] ?? false,
                    'club_id' => $school->id,
                ]);

                $relatedPeriods = [];

                if (isset($academicYear['periods']) && count($academicYear['periods']) > 0) {
                    if(isset($yearPeriod['is_active']) && $yearPeriod['is_active']) {
                        $this->desactivateAcademicPeriod($storedYear->id);
                    }

                    foreach ($academicYear['periods'] as $yearPeriod) {
                        $storedPeriod = $this->academicPeriodRepository->create([
                            'title' => $yearPeriod['title'] ?? null,
                            'start_date' => $yearPeriod['start_date'],
                            'end_date' => $yearPeriod['end_date'],
                            'academic_year_id' => $storedYear->id,
                            'is_active' => $yearPeriod['is_active'] ?? false
                        ]);

                        $relatedPeriods[] = $storedPeriod;
                    }
                }

                $storedYear['academic_periods'] = $relatedPeriods;

                $this->dailyControlPeriodAlumns($relatedPeriods);

                $relatedData[] = $storedYear;
            }

            return $relatedData;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Update a set of academical year items and relates it to a school
     * @return Array
     */
    public function updateAcademicYears($school, $academicYearId, $academicYears)
    {
        try {
            $relatedData = [];

            foreach ($academicYears as $academicYear) {
                
                if(isset($academicYear['is_active']) && $academicYear['is_active']) {
                    $this->desactivateAcademicYears($school->id);
                }
                
                $updatedYear = [
                    'title' => $academicYear['title'] ?? null,
                    'start_date' => $academicYear['start_date'],
                    'end_date' => $academicYear['end_date'],
                    'is_active' => $academicYear['is_active'] ?? false,
                    'club_id' => $school->id,
                ];

                $this->academicYearRepository->update($updatedYear, ['id' => $academicYearId]);

                $relatedPeriods = [];

                if (isset($academicYear['periods']) && count($academicYear['periods']) > 0) {
                    
                    if(isset($yearPeriod['is_active']) && $yearPeriod['is_active']) {
                        $this->desactivateAcademicPeriod($academicYearId);
                    }

                    foreach ($academicYear['periods'] as $yearPeriod) {
                        $data = [
                            'title' => $yearPeriod['title'] ?? null,
                            'start_date' => $yearPeriod['start_date'],
                            'end_date' => $yearPeriod['end_date'],
                            'academic_year_id' => $academicYearId,
                            'is_active' => $yearPeriod['is_active'] ?? false
                        ];

                        $period = isset($yearPeriod['id']) ? $this->academicPeriodRepository->updateOrCreate(
                            [ 'id' => $yearPeriod['id'] ], $data):
                            $this->academicPeriodRepository->create($data);

                        $relatedPeriods[] = $period;
                    }
                }

                $updatedYear['academic_periods'] = $relatedPeriods;

                $this->dailyControlPeriodAlumns($relatedPeriods);

                $relatedData[] = $updatedYear;
            }

            return $relatedData;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Generate regiter daily control by period of alumns
     */
    private function dailyControlPeriodAlumns($periods)
    {
        $key = array_search(true, array_column($periods, 'is_active'));

        if($key < 0) { return; }

        $periodActive = $periods[$key];

        $this->dailyControlService->generateDailyControlAlumns($periodActive);
    }

    /**
     * Deletes a specific academic year
     * @return bool
     * 
     * @OA\Schema(
     *  schema="DeleteSchoolAcademicYearResponse",
     *  type="object",
     *  description="Deletes an school academic year",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="School academic year deleted"),
     *  @OA\Property(
     *      property="data",
     *      type="boolean",
     *      example="true"
     *  ),
     * )
     */
    public function delete(AcademicYear $academicYear)
    {
        try {
            return $this->academicYearRepository->delete($academicYear->id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Desactive academic year by school center
     * 
     * @param $school_center
     */
    private function desactivateAcademicYears($school_center) 
    {
        $this->academicYearRepository->update([
            'is_active' => false
        ],[
            'club_id' => $school_center
        ], true);
    }

    /**
     * Desactive academic period by academic year
     * 
     * @param $academic_year
     */
    private function desactivateAcademicPeriod($academic_year) 
    {
        $this->academicPeriodRepository->update([
            'is_active' => false
        ],[
            'academic_year_id' => $academic_year
        ], true);
    }

    /**
     * Delete periods academic by academic year
     * 
     * @param $academic_year
     */
    private function deleteAcademicPeriods($academic_year)
    {
        $this->academicPeriodRepository->deleteByCriteria([
            'academic_year_id' => $academic_year
        ]);
    }
}
