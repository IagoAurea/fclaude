<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;

// Repositories
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Club\Repositories\Interfaces\AcademicYearRepositoryInterface;
use Modules\Club\Repositories\Interfaces\AcademicPeriodRepositoryInterface;

class AcademicYearTableSeeder extends Seeder
{
    /**
     * Constant to determine max 
     */
    const MAX_ACADEMIC_YEARS = 2;
    const MAX_ACADEMIC_PERIODS = 3;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $academicYearRepository;

    /**
     * @var object
     */
    protected $academicPeriodRepository;

    /**
     * @var object
     */
    protected $faker;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        ClubRepositoryInterface $clubRepository,
        AcademicYearRepositoryInterface $academicYearRepository,
        AcademicPeriodRepositoryInterface $academicPeriodRepository
    ) {
        $this->clubRepository = $clubRepository;
        $this->academicYearRepository = $academicYearRepository;
        $this->academicPeriodRepository = $academicPeriodRepository;
        $this->faker = Factory::create();
    }

    /**
     * 
     */
    private function parseSubYear($index, $year)
    {
        if ($index == 0) {
            return [
                'start_date' => "$year-09-01 00:00:00",
                'end_date' => "$year-12-19 12:59:59"
            ];
        }

        $nextYear = $year + 1;
        
        if ($index == 1) {
            return [
                'start_date' => "$nextYear-01-07 00:00:00",
                'end_date' => "$nextYear-04-15 12:59:59"
            ];
        }

        return [
            'start_date' => "$nextYear-04-16 00:00:00",
            'end_date' => "$nextYear-07-31 12:59:59"
        ];
    }

    /**
     * Create a maximum of 2 or more academic years per academy set on the constant var
     * 
     * @return void
     */
    private function runSeeder()
    {
        $academies = $this->clubRepository->findBy([
            'club_type_id' => 2
        ]);

        // Loop through all academies
        foreach ($academies as $academy) {
            $initialYear = date('Y') - self::MAX_ACADEMIC_YEARS; 

            // Set a maximum of academic years relation
            for ($i = 0; $i < self::MAX_ACADEMIC_YEARS; $i++) {
                $year = $this->academicYearRepository->create([
                    'club_id' => $academy->id, 
                    'title' => $this->faker->name(),
                    'start_date' => $initialYear . '-12-01 00:00:00', 
                    'end_date' => $initialYear + 1 . '-12-31 11:59:59', 
                    'is_active' => $initialYear == date('Y') - 1 ? true : false,
                ]);

                for ($j = 0; $j < self::MAX_ACADEMIC_PERIODS; $j ++) {
                    $parsedYear = $this->parseSubYear($j, $initialYear);
                    
                    $this->academicPeriodRepository->create([
                        'academic_year_id' => $year->id, 
                        'title' => $this->faker->name(),
                        'start_date' => $parsedYear['start_date'],
                        'end_date' => $parsedYear['end_date'],
                    ]);
                }

                $initialYear ++;
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
        $this->runSeeder();
    }
}
