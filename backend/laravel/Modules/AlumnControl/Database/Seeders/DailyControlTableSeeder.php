<?php

namespace Modules\AlumnControl\Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use Modules\AlumnControl\Repositories\Interfaces\DailyControlItemRepositoryInterface;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class DailyControlTableSeeder extends Seeder
{
    /**
     * @var object $dailyControlItemRepository
     */
    protected $dailyControlItemRepository;

    /**
     * @var object
     */
    protected $dailyControlRepository;

    /**
     * @var object
     */
    protected $classroomRepository;

    /**
     * @var object
     */
    protected $classroomAcademicYearRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        DailyControlItemRepositoryInterface $dailyControlItemRepository,
        DailyControlRepositoryInterface $dailyControlRepository,
        ClassroomRepositoryInterface $classroomRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository
    ) {
        $this->dailyControlItemRepository = $dailyControlItemRepository;
        $this->dailyControlRepository = $dailyControlRepository;
        $this->classroomRepository = $classroomRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
    }

    /**
     * @return void
     */
    protected function createDailyControlRegistries()
    {
        // Get all daily items
        $dailyItems = $this->dailyControlItemRepository->findAll();

        // Loop through each classroom
        foreach ($this->classroomRepository->findAll() as $classroom) {
            // Go through every academic year
            foreach ($classroom->academicYears as $academicYear) {
                // And manually search for its database relation table in order to retrieve alumn list
                $classroomYear = $this->classroomAcademicYearRepository->findOneBy([
                    'id' => $academicYear->classroom_academic_year_id
                ]);
    
                // Then loop every academic period
                foreach ($academicYear->academicPeriods as $academicPeriod) {
                    // Then on every alumn related to the database table relation searched before                    
                    foreach ($classroomYear->alumns as $alumn) {
                        // Loop every daily item
                        foreach ($dailyItems as $dailyItem) {
                            // Create every single item
                            $this->dailyControlRepository->create([
                                'alumn_id' => $alumn->id,
                                'daily_control_item_id' => $dailyItem->id,
                                'classroom_academic_year_id' => $academicYear->classroom_academic_year_id,
                                'academic_period_id' => $academicPeriod->id,
                                'count' => random_int(0, 15),
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDailyControlRegistries();
    }
}
