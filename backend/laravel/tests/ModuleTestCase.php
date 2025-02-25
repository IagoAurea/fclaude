<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\User\Entities\User;

abstract class ModuleTestCase extends BaseTestCase
{
    use CreatesApplication;
    
    /**
     * The faker instance
     *
     * @var \Faker\Factory
     */
    public $faker;

    /**
     * The admin user instance
     *
     * @var User
     */
    public $admin;
    
    /**
     * The admin user name constant
     *
     * @var string
     */
    const admin = 'administrador';

    /**
     * Initial setup for the modules test,
     * it sets a faker instance for using
     * mocked data as well as an admin
     * user and admin token for
     * requesting
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();
        $this->admin = User::where('username', self::admin)->first();
        $this->admin_token = $this->admin->generateToken(false)->accessToken;
    }

    /**
     * Performs a JSON Get request to the given
     * route using the supplied token
     * 
     * @return \Illuminate\Testing\TestResponse
     */
    protected function doGet($route, $token = 0)
    {
        $headers = [];

        if ($token) {
            $headers = array_merge($headers, ['Authorization' => 'Bearer ' . $token]);
        }

        return $this->getJson(
            $route,
            $headers
        );
    }

    /**
     * Performs a JSON Post request to the given
     * route using the supplied token and
     * the payload
     * 
     * @return \Illuminate\Testing\TestResponse
     */
    protected function doPost($route, $payload, $token = 0)
    {
        $headers = [];

        if ($token) {
            $headers = array_merge($headers, ['Authorization' => 'Bearer ' . $token]);
        }

        return $this->postJson(
            $route,
            $payload,
            $headers
        );
    }

    /**
     * Performs a JSON Put request to the given
     * route using the supplied token and 
     * the payload
     * 
     * @return \Illuminate\Testing\TestResponse
     */
    protected function doPut($route, $payload, $token = 0)
    {
        $headers = [];

        if ($token) {
            $headers = array_merge($headers, ['Authorization' => 'Bearer ' . $token]);
        }

        return $this->putJson(
            $route,
            $payload,
            $headers
        );
    }

    /**
     * Performs a JSON Delete request to the given
     * route using the supplied token and 
     * the payload
     * 
     * @return \Illuminate\Testing\TestResponse
     */
    protected function doDelete($route, $token = 0)
    {
        $headers = [];

        if ($token) {
            $headers = array_merge($headers, ['Authorization' => 'Bearer ' . $token]);
        }

        return $this->deleteJson(
            $route,
            [],
            $headers
        );
    }
}