<?php

namespace Modules\AlumnControl\Repositories;

use App\Services\ModelRepository;
use Modules\AlumnControl\Entities\DailyControl;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyControlRepository extends ModelRepository implements DailyControlRepositoryInterface
{
    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new Repository instance
     */
    public function __construct(DailyControl $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Finds all control items related to an alumn depending on parameters sent
     *
     * @return array
     */
    public function findAlumnItems($alumnId, $classroomAcademicYearId, $academicPeriodId, $date)
    {
        $locale = app()->getLocale();

        $yearColumns = [
            DB::raw("ROW_NUMBER() OVER (ORDER BY daily_control.alumn_id) AS id"),
            'daily_control.alumn_id',
            'daily_control.daily_control_item_id',
            'daily_control_items.order',
            'daily_control_items.image_id',
            'resources.url as image_url',
            DB::raw("SUM(daily_control.count) AS count"),
            'daily_control_items_translations.name AS control_name',
            DB::raw("MAX(daily_control.updated_at) as updated_at"),
            DB::raw("MAX(daily_control.reset_at) as reset_at")
        ];

        $periodColumns = [
            'daily_control.id',
            'daily_control.alumn_id',
            'daily_control.daily_control_item_id',
            'daily_control_items.order',
            'daily_control_items.image_id',
            'resources.url as image_url',
            'daily_control.academic_period_id',
            'daily_control.count',
            'daily_control_items_translations.name AS control_name',
            'daily_control.updated_at',
            'daily_control.reset_at'
        ];

        // Choose the selection column array to be performed on the query
        $selectColumns = !$academicPeriodId ? $yearColumns : $periodColumns;

        // Build the query
        $query = DB::table('daily_control')->select($selectColumns)
            ->leftJoin('daily_control_items', 'daily_control.daily_control_item_id', '=', 'daily_control_items.id')
            ->leftJoin(
                'daily_control_items_translations', function ($join) use ($locale) {
                    $join->on('daily_control_items_translations.daily_control_item_id', '=', 'daily_control_items.id');
                    $join->on('daily_control_items_translations.locale','=',DB::raw("'".$locale."'"));
                }
            )
            ->rightJoin('resources', 'daily_control_items.image_id', '=', 'resources.id')
            ->where('daily_control.alumn_id', $alumnId)
            ->where('daily_control.classroom_academic_year_id', $classroomAcademicYearId)
            ->orderBy('daily_control_items.order');

        // Make aggroupments depending on if the academic period is sent
        if ($academicPeriodId) {
            $query->where('daily_control.academic_period_id', $academicPeriodId);
        } else {
            $query->groupBy(
                'daily_control.daily_control_item_id',
                'daily_control_items.id',
                'daily_control.alumn_id',
                'daily_control_items_translations.name',
                'resources.id'
            );
        }

        // Filter by date in case the parameter is sent
        if ($date) {
            $parsedDate = Carbon::createFromFormat('Y-m-d', $date);
            $query->whereBetween('daily_control.created_at',
                [
                    $parsedDate->startOfDay()->toDateTimeString(),
                    $parsedDate->endOfDay()->toDateTimeString()
                ]
            );
        }

        return $query->get();
    }

    /**
     * Resets the count set on every item sent through params
     *
     * @return void
     */
    public function reset($classroomAcademicYearId, $academicPeriodId, $alumnId)
    {
        $query = DB::table('daily_control')->where('classroom_academic_year_id', $classroomAcademicYearId);

        if ($academicPeriodId) {
            $query->where('academic_period_id', $academicPeriodId);
        }

        if ($alumnId) {
            $query->where('alumn_id', $alumnId);
        }

        $query->update([
            'count' => 0,
            'updated_at' => now(),
            'reset_at' => now()
        ]);
    }
}
