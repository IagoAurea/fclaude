<?php

namespace Modules\Alumn\Database\Seeders;

use Illuminate\Database\Seeder;

use Modules\Alumn\Services\AlumnService;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\ClassroomAcademicYearAlumnRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportPositionRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Faker\Factory;

class AlumnTableSeeder extends Seeder
{
    const ALUMNS_LIMIT = 5;
    const MIN_HEIGHT = 120;
    const MAX_HEIGHT = 215;
    const MIN_WEIGHT = 45;
    const MAX_WEIGHT = 145;
    const DECIMALS = 2;
    const FAMILY_MOTHER_CODE = 'mother';
    const FAMILY_FATHER_CODE = 'father';

    /**
     * @var object
     */
    protected $alumnService;

    /**
     * @var object
     */
    protected $countryRepository;

    /**
     * @var object
     */
    protected $classroomRepository;
    
    /**
     * @var object
     */
    protected $positionRepository;

    /**
     * @var object
     */
    protected $academicYearAlumnRepository;

    /**
     * @var object
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $faker;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        AlumnService $alumnService,
        CountryRepositoryInterface $countryRepository,
        ClassroomRepositoryInterface $classroomRepository,
        SportPositionRepositoryInterface $positionRepository,
        ClassroomAcademicYearAlumnRepositoryInterface $academicYearAlumnRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->alumnService = $alumnService;
        $this->countryRepository = $countryRepository;
        $this->classroomRepository = $classroomRepository;
        $this->positionRepository = $positionRepository;
        $this->academicYearAlumnRepository = $academicYearAlumnRepository;
        $this->userRepository = $userRepository;

        $this->faker = Factory::create();
    }

    /**
     * Get a random country for insertion
     *
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
     * Get random familiar data depending on the code sent
     */
    private function generateFamilyData($code)
    {
        return [
            $code . '_full_name' =>  $this->faker->name(),
            $code . '_email' => $this->faker->email(),
            $code . '_mobile_phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
            $code . '_phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
        ];
    }

    /**
     * Loops through every classroom and inserts random data on it
     *
     * @return void
     */
    private function createAlumns()
    {
        // Get all the available classrooms
        $classrooms = $this->classroomRepository->findAll();

        // Loop though all classrooms and start storing alumns into database
        foreach ($classrooms as $classroom) {
            // Get through every academic year the classroom is involved to
            foreach ($classroom->academicYears as $classYear) {
                // Create the alumn limit amount per class year
                for ($i = 0; $i < self::ALUMNS_LIMIT; $i ++) {
                    $rand_country = $this->getRandomCountry();
    
                    $alumn_data = [
                        'full_name' =>  $this->faker->name(),
                        'list_number' => $this->faker->numberBetween(1, 35),
                        'gender_id' => $this->faker->numberBetween(0, 2),
                        'date_birth' => $this->faker->dateTimeBetween('-25 years', '-15 years'),
                        'height' => $this->faker->numberBetween(self::MIN_HEIGHT, self::MAX_HEIGHT),
                        'weight' => $this->faker->randomFloat(self::DECIMALS, self::MIN_WEIGHT, self::MAX_WEIGHT),
                        'heart_rate' => $this->faker->numberBetween(60, 100),
                        'email' => $this->faker->unique()->email(),
                        'laterality_id' => $this->faker->numberBetween(0, 2),
                        'academical_emails' => '"[" ' . $this->faker->email() . ',' . $this->faker->email() . '"]"',
                        'virtual_space' => $this->faker->text(random_int(50, 120)),
                        'is_new_entry' => $this->faker->boolean(random_int(0, 50)),
                        'is_advanced_course' => $this->faker->boolean(random_int(0, 50)),
                        'is_repeater' => $this->faker->boolean(random_int(0, 50)),
                        'is_delegate' => $this->faker->boolean(random_int(0, 50)),
                        'is_sub_delegate' => $this->faker->boolean(random_int(0, 50)),
                        'has_digital_difficulty' => $this->faker->boolean(random_int(0, 50)),
                        'has_sport' => $this->faker->boolean(random_int(0, 50)),
                        'has_extracurricular_sport' => $this->faker->boolean(random_int(0, 50)),
                        'has_federated_sport' => $this->faker->boolean(random_int(0, 50)),
                    ];
    
                    $alumn_address = [
                        'street' => $this->faker->streetAddress(),
                        'postal_code' => $this->faker->postcode(),
                        'city' => $this->faker->city(),
                        'mobile_phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
                        'phone' => '"["' . $this->faker->e164PhoneNumber() . '"]"',
                        'country_id' => $rand_country->id,
                        'province_id' => $rand_country->provinces->random()->id,
                    ];
    
                    $mother_data = $this->generateFamilyData(self::FAMILY_MOTHER_CODE);
                    $father_data = $this->generateFamilyData(self::FAMILY_FATHER_CODE);
                    $rand_country = $this->getRandomCountry();
            
                    $family_address = [
                        'family_address_country_id' => $rand_country->id,
                        'family_address_province_id' => $rand_country->provinces->random()->id,
                        'family_address_street' => $this->faker->streetAddress(),
                        'family_address_postal_code' => $this->faker->postcode(),
                        'family_address_city' => $this->faker->city(),
                    ];
    
                    $this->alumnService->store(
                        $alumn_data,
                        $alumn_address,
                        $mother_data,
                        $father_data,
                        $family_address,
                        null,
                        random_int(1, 2),
                    );
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
        $this->createAlumns();
    }
}
