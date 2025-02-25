<?php

namespace Modules\Classroom\Tests\Fixtures;

use Modules\Classroom\Entities\Age;

trait AgeControllerFixturesTrait
{
    /**
     * The payload property will be used
     * to store the testing data for
     * every test case running
     *
     * @var mixed
     */
    private $payload = [];

    /**
     * Prepare the payload to be an array
     * of 2 Ages
     *
     * @return void
     */
    private function preparePayload()
    {
        $ages = Age::factory()
            ->count(2)
            ->create();

        $this->payload = $ages;
    }
}
