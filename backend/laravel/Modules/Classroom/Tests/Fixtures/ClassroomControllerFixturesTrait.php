<?php

namespace Modules\Classroom\Tests\Fixtures;

use Modules\Classroom\Entities\Classroom;

trait ClassroomControllerFixturesTrait
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
     * of 2 Classrooms
     *
     * @return void
     */
    private function preparePayload()
    {
        $subjects = Classroom::factory()
            ->count(2)
            ->create();

        $this->payload = $subjects;
    }
}
