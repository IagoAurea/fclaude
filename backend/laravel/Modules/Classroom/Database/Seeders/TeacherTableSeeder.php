<?php

namespace Modules\Classroom\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\TeacherRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Address\Services\AddressService;
use Faker\Factory;

class TeacherTableSeeder extends Seeder
{
    const CLUB_TEACHERS_LIMIT = 5;

    /**
     * @var object
     */
    protected $countryRepository;

    /**
     * @var object
     */
    protected $addressService;

    /**
     * @var object
     */
    protected $teacherRepository;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var object
     */
    protected $faker;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        CountryRepositoryInterface $countryRepository,
        ClubRepositoryInterface $clubRepository,
        AddressService $addressService,
        TeacherRepositoryInterface $teacherRepository
    ) {
        $this->countryRepository = $countryRepository;
        $this->clubRepository = $clubRepository;
        $this->addressService = $addressService;
        $this->teacherRepository = $teacherRepository;

        $this->faker = Factory::create();
    }

    /**
     * Get a random country for insertion
     * clubRepos
     * @return Object
     */
    private function getRandomCountry()
    {
        $rand_country = null;

        do {
            $rand_country = $this->countryRepository->findAll()->random();
        } while($rand_country->provinces->isEmpty());

        return $rand_country;
    }

    /**
     * Loops through every classroom and inserts random data on it
     * 
     * @return void
     */
    private function createTeachers()
    {
        // Get all academies
        $clubs = $this->clubRepository->findBy([
            'club_type_id' => 2
        ]);
        
        // Loop though all classrooms and start storing alumns into database
        foreach ($clubs as $club) {

            for ($i = 0; $i < self::CLUB_TEACHERS_LIMIT; $i ++) {
                // Randomly select all the variables
                $payload = [
                    'club_id' => $club->id,
                    'name' => $this->faker->name(),
                    'gender_id' => random_int(0, 1),
                    'username' => $this->faker->word(),
                    'birth_date' => $this->faker->dateTimeBetween('-55 years', '-25 years'),
                    'citizenship' => $this->faker->text(20),
                ];

                $teacher = $this->teacherRepository->create($payload);

                // Retrieve a random country for teacher address relation
                $randCountry = $this->getRandomCountry();
    
                $addressData = [
                    'street' => $this->faker->streetAddress(),
                    'postal_code' => $this->faker->postcode(),
                    'city' => $this->faker->city(),
                    'mobile_phone' => '[' . $this->faker->phoneNumber() .']',
                    'phone' => '[' . $this->faker->phoneNumber() .']',
                    'country_id' => $randCountry->id,
                    'province_id' => $randCountry->provinces->random()->id,
                ];
    
                $this->addressService->store($addressData, $teacher);
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
        $this->createTeachers();
    }
}
