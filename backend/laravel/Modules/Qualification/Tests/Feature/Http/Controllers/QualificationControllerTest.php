<?php

namespace Modules\Qualification\Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ModuleTestCase;

class QualificationControllerTest extends ModuleTestCase
{
    use DatabaseTransactions;

    /**
     * @test
     * Test return an endpoint with a list of periods
     *
     * @return void
     */
    public function test_period_index_list_an_emtpy_array()
    {

        $response = $this->doGet(route('qualification.periods.index'), $this->admin_token);

        $response->assertSee('List of periods');
        $response->assertJsonPath('data', []);
    }
}
