<?php

namespace Modules\Club\Database\Seeders;

use Illuminate\Database\Seeder;

// Repository Interfaces
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\User\Repositories\Interfaces\PermissionRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubTypeRepositoryInterface;
use Modules\Club\Repositories\Interfaces\SchoolCenterTypeRepositoryInterface;

// Services
use Modules\Club\Services\ClubService;

use Faker\Factory;

class SchoolCenterTableSeeder extends Seeder
{
    /**
     * List of the permission names that must be relatable to a club
     *
     * @var array
     */
    const PERMISSION_NAMES = [
        'club_list',
        'club_store',
        'club_read',
        'club_update',
        'club_delete',
    ];

    const NUMBERS_CLUBS= 4;

    /**
     * @var object
     */
    protected $countryRepository;

    /**
     * @var object
     */
    protected $clubService;

    /**
     * @var object
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $permissionRepository;

    /**
     * @var object
     */
    protected $clubTypeRepository;

    /**
     * @var object
     */
    protected $schoolCenterTypeRepository;

    /**
     * Instances a new seeder class.
     */
    public function __construct(
        CountryRepositoryInterface $countryRepository,
        ClubService $clubService,
        UserRepositoryInterface $userRepository,
        PermissionRepositoryInterface $permissionRepository,
        ClubTypeRepositoryInterface $clubTypeRepository,
        SchoolCenterTypeRepositoryInterface $schoolCenterTypeRepository
    ) {
        $this->countryRepository = $countryRepository;
        $this->clubService = $clubService;
        $this->userRepository = $userRepository;
        $this->permissionRepository = $permissionRepository;
        $this->clubTypeRepository = $clubTypeRepository;
        $this->schoolCenterTypeRepository = $schoolCenterTypeRepository;
        $this->faker = Factory::create();
    }

    /**
     * In this method we only create 1 club per user, by looping through every previously
     * stored user in the database.
     *
     * @return \Iterator
     */
    private function runSeeder()
    {
        // Get all the users
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            for ($i = 0; $i < random_int(1, 3); $i++) { 
                // Initialize the random country as a null value
                $randCountry = null;

                // As there are some countries that has no provinces, we must ensure that
                // we randomly get one that has this relationship. That's the reason of the
                // do-while loop inside here
                do {
                    $randCountry = $this->countryRepository->findAll()->random();
                } while($randCountry->provinces->isEmpty());

                // Randomize the data
                $data = [
                    'name' => $this->faker->company(),
                    'club_type_id' => $this->clubTypeRepository->findOneBy([
                        'code' => 'academic'
                    ])->id,
                    'webpage' => $this->faker->url(),
                    'email' => $this->faker->email(),
                    'school_center_type_id' => $this->schoolCenterTypeRepository->findAll()->random()->id,
                ];

                $addressData = [
                    'street' => $this->faker->streetAddress(),
                    'postal_code' => $this->faker->postcode(),
                    'city' => $this->faker->city(),
                    'mobile_phone' => '[' . $this->faker->phoneNumber() .']',
                    'phone' => '[' . $this->faker->phoneNumber() .']',
                    'country_id' => $randCountry->id,
                    'province_id' => $randCountry->provinces->random()->id,
                ];

                // And then just create the country related to an user
                $this->clubService->store($user, $data, $addressData, 'academic');
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
