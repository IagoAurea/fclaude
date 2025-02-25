<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;

// Repository Interfaces
use Modules\Generality\Repositories\Interfaces\StudyLevelRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\JobAreaRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubUserTypeRepositoryInterface;
use Modules\Club\Repositories\Interfaces\WorkingExperiencesRepositoryInterface;
use Modules\Club\Repositories\Interfaces\StaffRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubUserRepositoryInterface;
use Modules\Club\Repositories\Interfaces\PositionStaffRepositoryInterface;

use Faker\Factory;

class StaffTableSeeder extends Seeder
{

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

    public function __construct(
        ClubRepositoryInterface $clubRepository,
        UserRepositoryInterface $userRepository,
        StudyLevelRepositoryInterface $studyRepository,
        JobAreaRepositoryInterface $jobsRepository,
        ClubUserTypeRepositoryInterface $clubUserTypeService,
        WorkingExperiencesRepositoryInterface $workingExperiencesRepository,
        StaffRepositoryInterface $staffRepository,
        ClubUserRepositoryInterface $clubUserRepository,
        PositionStaffRepositoryInterface $positionStaffRepository
        
    ) {
        $this->clubRepository = $clubRepository;
        $this->userRepository = $userRepository;
        $this->studyRepository = $studyRepository;
        $this->jobsRepository = $jobsRepository;
        $this->clubUserTypeService = $clubUserTypeService;
        $this->workingExperiencesRepository = $workingExperiencesRepository;
        $this->staffRepository = $staffRepository;
        $this->clubUserRepository = $clubUserRepository;
        $this->positionStaffRepository = $positionStaffRepository;
        $this->faker = Factory::create();
    }

    /**
    * @return  Array
    * returns random data to create a user type staff 
    */
    public function generateDataStaff($user)
    {

       // $responsibility = array("CEO", "Administrador", "Asistente", "Utilero", "Masajista", "CMO");
        $positionsStaff = $this->positionStaffRepository->getRandom()->first();
        
        $createRandonData = [
            "position_staff_id" => $positionsStaff->id,
            'birth_date' => $this->faker->dateTimeBetween('1980-01-01', '2000-12-31')->format('Y-m-d'),
            'alias' => $this->faker->name(),
            'additional_information' => $this->faker->text($maxNbChars = 200),
            'jobs_area_id' => $this->clubUserTypeService->getUserTypeByName('staff')->id,
            "user_id" => $user->id,
            'name' => $this->faker->name(),
            'email' => $user->email,
            'gender' => 1,
            'study_level_id' => 1,
            'city' => $this->faker->name(),
            'zipcode' => random_int(1000, 9999),
            'address' => $this->faker->Address()
        ];

        return $createRandonData;
    }

    /**
    * @return  Array
    * returns random data to associate a user to a club 
    */
    public function generateUserClub($user_id)
    {

        $clubUserData = [
            "user_id" => $user_id,
            "club_id" =>  $this->clubRepository->getRandomClub()->id,
            "club_user_type_id" => $this->clubUserTypeService->getUserTypeByName('staff')->id
        ];

        return $clubUserData;
    }

    /**
    * @return  String
    * insert data from work experiences to a user type staff
    */
    public function generateWorkingExperience($staff_id)
    {
        $responsibility = array("Segundo Entrenador", "Preparador de Arqueros", "Fisioterapeuta", "Preparador Fisico");
        for ($i=0; $i < 3; $i++) { 

            $workingExperience = [
                "club" => $this->faker->company(). "F.C",
                "occupation" => $responsibility[array_rand($responsibility, 1)],
                "start_date" => $this->faker->dateTimeBetween('2007-01-01', '2009-12-31')->format('Y-m-d'),
                "finish_date" => $this->faker->dateTimeBetween('2010-01-01', '2020-12-31')->format('Y-m-d'),
                "staff_id" => $staff_id
            ];

            $this->workingExperiencesRepository->create($workingExperience);
        }

        return ['success' => true];

    }

    /**
     * Run the database seeds.
     *
     * @return void 
     */

    public function run()
    {
        // Get all the users
        $users = $this->userRepository->findAll();

        
        foreach ($users as $user) {

            // insert user staff info 
            $staff = $this->staffRepository->create($this->generateDataStaff($user));


            //associate the staff user with a club 
            $this->clubUserRepository->create($this->generateUserClub($user->id));


            //associate the staff user with work experiences 
            $this->generateWorkingExperience($staff->id);

        }

    }
}
