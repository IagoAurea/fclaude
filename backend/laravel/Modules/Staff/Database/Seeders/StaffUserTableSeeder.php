<?php

namespace Modules\Staff\Database\Seeders;

use Illuminate\Database\Seeder;

// Repository Interfaces
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\StudyLevelRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\JobAreaRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Club\Repositories\Interfaces\PositionStaffRepositoryInterface;

// Services
use Modules\Staff\Services\StaffService;

use Faker\Factory;

class StaffUserTableSeeder extends Seeder
{
    const MAX_STAFF_CLUB_USERS = 2;
    const MAX_STAFF_TEAM_USERS = 5;

    /**
     * @var object
     */
    protected $countryRepository;

    /**
     * @var object
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $studyRepository;

    /**
     * @var object
     */
    protected $jobsRepository;

    /**
     * @var object
     */
    protected $positionStaffRepository;

    /**
     * @var object
     */
    protected $staffService;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        CountryRepositoryInterface $countryRepository,
        ClubRepositoryInterface $clubRepository,
        UserRepositoryInterface $userRepository,
        StudyLevelRepositoryInterface $studyRepository,
        JobAreaRepositoryInterface $jobsRepository,
        PositionStaffRepositoryInterface $positionStaffRepository,
        StaffService $staffService
    ) {
        $this->countryRepository = $countryRepository;
        $this->clubRepository = $clubRepository;
        $this->userRepository = $userRepository;
        $this->studyRepository = $studyRepository;
        $this->jobsRepository = $jobsRepository;
        $this->positionStaffRepository = $positionStaffRepository;
        $this->staffService = $staffService;
        $this->faker = Factory::create();
    }

    /**
    * @return  Array
    * returns random data to create a user type staff 
    */
    public function createUserData()
    {
        return [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'username' => $this->faker->unique()->userName(),
            'birth_date' => $this->faker->dateTimeBetween('1980-01-01', '2000-12-31')->format('Y-m-d'),
        ];
    }

    /**
     * Get a random country for insertion
     * clubRepos
     * @return Object
     */
    private function getRandomCountry($countries)
    {
        $rand_country = null;

        do {
            $rand_country = $countries->random();
        } while($rand_country->provinces->isEmpty());

        return $rand_country;
    }

    /**
     * 
     */
    private function createAddressData($countries)
    {
        $randCountry = $this->getRandomCountry($countries);

        return [
            'street' => $this->faker->streetAddress(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'mobile_phone' => '[' . $this->faker->phoneNumber() .']',
            'phone' => '[' . $this->faker->phoneNumber() .']',
            'country_id' => $randCountry->id,
            'province_id' => $randCountry->provinces->random()->id,
        ];
    }

    /**
     * 
     */
    private function createStaffData($jobAreas, $studyLevels, $staffPositions)
    {
        return [
            'responsibility' => $this->faker->sentence(),
            'jobs_area_id' => $jobAreas->random()->id,
            'study_level_id' => $studyLevels->random()->id,
            'additional_information' => $this->faker->paragraph(),
            'position_staff_id' => $staffPositions->random()->id,
        ];
    }

    /**
     * 
     */
    public function createStaffs()
    {
        // Get all academies
        $clubs = $this->clubRepository->findBy([
            'club_type_id' => 1
        ]);

        $countries = $this->countryRepository->findAll();
        $jobAreas = $this->jobsRepository->findAll();
        $studyLevels = $this->studyRepository->findAll();
        $staffPositions = $this->positionStaffRepository->findAll();

        foreach ($clubs as $club) {
            // Club staff users
            for ($i = 0; $i < self::MAX_STAFF_CLUB_USERS; $i++) {
                $userData = $this->createUserData();
                $addressData = $this->createAddressData($countries);
                $staffData = $this->createStaffData($jobAreas, $studyLevels, $staffPositions);
    
                $this->staffService->store(
                    $club,
                    $userData,
                    $addressData,
                    $staffData
                );

                foreach ($club->teams as $team) {
                    for ($j = 0; $j < self::MAX_STAFF_TEAM_USERS; $j++) {
                        $userData = $this->createUserData();
                        $addressData = $this->createAddressData($countries);
                        $staffData = $this->createStaffData($jobAreas, $studyLevels, $staffPositions);
            
                        $this->staffService->store(
                            $team,
                            $userData,
                            $addressData,
                            $staffData
                        );
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
        $this->createStaffs();
    }
}
