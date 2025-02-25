<?php

namespace Modules\User\Database\Seeders;

use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\BaseSeeder;
use Faker\Factory;

class UsersTableSeeder extends BaseSeeder
{

    /**
     * @var object
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $countryRepository;

    /**
     * @var object
     */
    protected $faker;

    public function __construct(UserRepositoryInterface $userRepository, CountryRepositoryInterface $countryRepository)
    {
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
        $this->faker = Factory::create();
    }

    /**
     * @return void
     */
    protected function createUsers(array $elements)
    {
        foreach($elements as $elm) 
        {
            $role = $elm['role'];

            unset($elm['role']);

            $user = $this->userRepository->create($elm);

            $user->assignRole($role);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        $countries = $this->countryRepository->findAll();

        yield [
            [
                'full_name' => 'Administrador del sistema',
                'email' => 'administrador@fisicalcoach.com',
                'username' => 'administrador',
                'password' => '123456',
                'active' => true,
                'email_verified_at' => now(),
                'address' => $this->faker->address(),
                'country_id' => $countries->pluck('id')->random(),
                'role' => 'admin'
            ],
            [
                'full_name' => 'Usuario api',
                'email' => 'api_xfs5@fisicalcoach.com',
                'username' => 'user_api',
                'password' => '123456',
                'active' => true,
                'email_verified_at' => now(),
                'address' => $this->faker->address(),
                'country_id' => $countries->pluck('id')->random(),
                'role' => 'api'
            ],
            [
                'full_name' => 'David Martinez',
                'email' => 'user_55sy6csdmp@gmail.com',
                'username' => 'user_55sy6csdmp',
                'password' => '123456',
                'active' => true,
                'email_verified_at' => now(),
                'address' => $this->faker->address(),
                'country_id' => $countries->pluck('id')->random(),
                'role' => 'user'
            ],
            [
                'full_name' => 'Cliente',
                'email' => 'cliente@fisicalcoach.com',
                'username' => 'cliente',
                'password' => '123456',
                'active' => true,
                'email_verified_at' => now(),
                'address' => $this->faker->address(),
                'country_id' => $countries->pluck('id')->random(),
                'role' => 'user'
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createUsers($this->get()->current());
    }
}
