<?php

namespace Modules\Classroom\Tests\Feature\Http\Controllers;

use Modules\Classroom\Repositories\Interfaces\SubjectRepositoryInterface;
use Modules\Classroom\Tests\Fixtures\SubjectControllerFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Mockery\MockInterface;
use Tests\ModuleTestCase;
use Mockery;

class SubjectControllerTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use SubjectControllerFixturesTrait;

    /**
     * @test
     * 
     * Test return an endpoint with a list of the ages
     *
     * @return void
     */
    public function test_index_displays_list_of_subjects()
    {
        $this->preparePayload();

        $this->instance(
            SubjectRepositoryInterface::class,
            Mockery::mock(SubjectRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['club_id' => $this->payload[0]->club_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doGet(route('classroom.subjects.index', [$this->payload[0]->club_id]), $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee('List of subjects');
        $response->assertJsonFragment(['name' => $this->payload[0]->name]);
    }

    /**
     * @test
     * 
     * Test return an endpoint with a given subject
     *
     * @return void
     */
    public function test_show_displays_a_given_subjects()
    {
        $this->preparePayload();

        $this->instance(
            SubjectRepositoryInterface::class,
            Mockery::mock(SubjectRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doGet(route('classroom.subjects.show', [$this->payload[0]->club_id, $this->payload[0]->id]), $this->admin_token);
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $this->payload[0]->name]);
    }

    /**
     * @test
     * 
     * Test return an endpoint for store a new subject
     *
     * @return void
     */
    public function test_store_a_new_subject()
    {
        $this->preparePayload();

        $this->instance(
            SubjectRepositoryInterface::class,
            Mockery::mock(SubjectRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('create')
                    ->with(['name' => $this->payload[0]->name, 'club_id' => $this->payload[0]->club_id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doPost(route('classroom.subjects.store', [$this->payload[0]->club_id]), ['name' => $this->payload[0]->name], $this->admin_token);
        $response->assertStatus(201);
        $response->assertSee(sprintf('Subject created'));
    }

    /**
     * @test
     * 
     * Test return an endpoint for updating an existing subject
     *
     * @return void
     */
    public function test_update_an_existing_subject()
    {
        $this->preparePayload();

        $this->instance(
            SubjectRepositoryInterface::class,
            Mockery::mock(SubjectRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doPut(route('classroom.subjects.update', [$this->payload[0]->club_id, $this->payload[0]->id]), ['name' => $this->payload[0]->name], $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee(sprintf('Subject updated'));
    }

    /**
     * @test
     * 
     * Test return an endpoint for deleting a subject
     *
     * @return void
     */
    public function test_destroy_an_existing_subject()
    {
        $this->preparePayload();

        $this->instance(
            SubjectRepositoryInterface::class,
            Mockery::mock(SubjectRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doDelete(route('classroom.subjects.destroy', [$this->payload[0]->club_id, $this->payload[0]->id]), $this->admin_token);
        $response->assertStatus(204);
    }
}
