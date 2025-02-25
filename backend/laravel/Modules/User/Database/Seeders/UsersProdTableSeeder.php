<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;

class UsersProdTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $userRepository;

    /**
     * @var object
     */
    protected $countryRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        CountryRepositoryInterface $countryRepository)
    {
        $this->userRepository = $userRepository;
        $this->countryRepository = $countryRepository;
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
                'password' => 'Z8RcAhRzVF',
                'active' => true,
                'email_verified_at' => now(),
                'country_id' => $countries->pluck('id')->random(),
                'role' => 'admin'
            ],
            [
                'full_name' => 'Usuario 3d',
                'email' => 'user3d@fisicalcoach.com',
                'username' => 'user_3d',
                'password' => 'b4EWaq2Hn2',
                'active' => true,
                'email_verified_at' => now(),
                'country_id' => $countries->pluck('id')->random(),
                'role' => 'api'
            ],
            [
                'full_name' => 'Usuario Demo',
                'email' => 'demo@fisicalcoach.com',
                'username' => 'demo',
                'password' => 'demo',
                'active' => true,
                'email_verified_at' => now(),
                'country_id' => $countries->pluck('id')->random(),
                'role' => 'user'
            ]
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
