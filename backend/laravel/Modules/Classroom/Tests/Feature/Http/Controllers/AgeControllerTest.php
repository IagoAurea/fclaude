<?php

namespace Modules\Classroom\Tests\Feature\Http\Controllers;

use Modules\Classroom\Repositories\Interfaces\AgeRepositoryInterface;
use Modules\Classroom\Tests\Fixtures\AgeControllerFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Mockery\MockInterface;
use Tests\ModuleTestCase;
use Mockery;

class AgeControllerTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use AgeControllerFixturesTrait;

    /**
     * @test
     * 
     * Test return an endpoint with a list of the ages
     *
     * @return void
     */
    public function test_index_displays_list_of_ages()
    {
        $this->preparePayload();

        $this->instance(
            AgeRepositoryInterface::class,
            Mockery::mock(AgeRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findAll')
                    ->with()
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doGet(route('classroom.ages.index'), $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee('List of ages');
        $response->assertJsonFragment(['range' => $this->payload[0]->range]);
    }

    /**
     * @test
     * 
     * Test return an endpoint with a given age
     *
     * @return void
     */
    public function test_show_displays_list_of_ages()
    {
        $this->preparePayload();

        $this->instance(
            AgeRepositoryInterface::class,
            Mockery::mock(AgeRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doGet(route('classroom.ages.show', [$this->payload[0]->id]), $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee(sprintf('Age with the id: %s', $this->payload[0]->id));
        $response->assertJsonFragment(['range' => $this->payload[0]->range]);
    }

    /**
     * @test
     * 
     * Test return an endpoint for store a new age
     *
     * @return void
     */
    public function test_store_a_new_age()
    {
        $this->preparePayload();

        $this->instance(
            AgeRepositoryInterface::class,
            Mockery::mock(AgeRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('create')
                    ->with(['range' => $this->payload[0]->range])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doPost(route('classroom.ages.store'), ['range' => $this->payload[0]->range], $this->admin_token);
        $response->assertStatus(201);
        $response->assertSee(sprintf('Age created'));
    }

    /**
     * @test
     * 
     * Test return an endpoint for updating an existing age
     *
     * @return void
     */
    public function test_update_an_existing_age()
    {
        $this->preparePayload();

        $this->instance(
            AgeRepositoryInterface::class,
            Mockery::mock(AgeRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doPut(route('classroom.ages.update', [$this->payload[0]->id]), ['range' => $this->payload[0]->range], $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee(sprintf('Age updated'));
    }

    /**
     * @test
     * 
     * Test return an endpoint for deleting an age
     *
     * @return void
     */
    public function test_destroy_an_existing_age()
    {
        $this->preparePayload();

        $this->instance(
            AgeRepositoryInterface::class,
            Mockery::mock(AgeRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doDelete(route('classroom.ages.destroy', [$this->payload[0]->id]), $this->admin_token);
        $response->assertStatus(204);
    }
}
