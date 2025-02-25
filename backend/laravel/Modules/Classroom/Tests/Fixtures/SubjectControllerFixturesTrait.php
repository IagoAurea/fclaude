<?php

namespace Modules\Classroom\Tests\Fixtures;

use Modules\Classroom\Entities\Subject;

trait SubjectControllerFixturesTrait
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
     * of 2 Subjects
     *
     * @return void
     */
    private function preparePayload()
    {
        $subjects = Subject::factory()
            ->count(2)
            ->create();

        $this->payload = $subjects;
    }
}
