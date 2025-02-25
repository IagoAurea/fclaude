<?php

namespace Modules\Classroom\Tests\Feature\Http\Controllers;

use Modules\Classroom\Repositories\Interfaces\TeacherRepositoryInterface;
use Modules\Classroom\Tests\Fixtures\TeacherControllerFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Mockery\MockInterface;
use Tests\ModuleTestCase;
use Mockery;

class TeacherControllerTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use TeacherControllerFixturesTrait;

    /**
     * @test
     * 
     * Test return an endpoint with a list of the ages
     *
     * @return void
     */
    public function test_index_displays_list_of_teachers()
    {
        $this->preparePayload();

        $this->instance(
            TeacherRepositoryInterface::class,
            Mockery::mock(TeacherRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['club_id' => $this->payload[0]->club_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doGet(route('classroom.teachers.index', [$this->payload[0]->club_id]), $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee('List of teachers');
        $response->assertJsonFragment(['name' => $this->payload[0]->name]);
    }

    /**
     * @test
     * 
     * Test return an endpoint with a given teacher
     *
     * @return void
     */
    public function test_show_displays_a_given_teachers()
    {
        $this->preparePayload();

        $this->instance(
            TeacherRepositoryInterface::class,
            Mockery::mock(TeacherRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doGet(route('classroom.teachers.show', [$this->payload[0]->club_id, $this->payload[0]->id]), $this->admin_token);
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $this->payload[0]->name]);
    }

    /**
     * @test
     * 
     * Test return an endpoint for store a new teacher
     *
     * @return void
     */
    public function test_store_a_new_teacher()
    {
        $this->preparePayload();

        $this->instance(
            TeacherRepositoryInterface::class,
            Mockery::mock(TeacherRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('create')
                    ->with([
                        'name' => $this->payload[0]->name,
                        'gender' => $this->payload[0]->gender,
                        'alias' => $this->payload[0]->alias,
                        'date_of_birth' => $this->payload[0]->date_of_birth,
                        'citizenship' => $this->payload[0]->citizenship,
                        'club_id' => $this->payload[0]->club_id
                    ])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doPost(route('classroom.teachers.store', [$this->payload[0]->club_id]), [
            'name' => $this->payload[0]->name,
            'gender' => $this->payload[0]->gender,
            'alias' => $this->payload[0]->alias,
            'date_of_birth' => $this->payload[0]->date_of_birth,
            'citizenship' => $this->payload[0]->citizenship,
        ], $this->admin_token);
        $response->assertStatus(201);
        $response->assertSee(sprintf('Teacher created'));
    }

    /**
     * @test
     * 
     * Test return an endpoint for updating an existing teacher
     *
     * @return void
     */
    public function test_update_an_existing_teacher()
    {
        $this->preparePayload();

        $this->instance(
            TeacherRepositoryInterface::class,
            Mockery::mock(TeacherRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $payload = [
            'name' => 'modified',
        ];


        $response = $this->doPut(route('classroom.teachers.update', [$this->payload[0]->club_id, $this->payload[0]->id]), $payload, $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee(sprintf('Teacher updated'));
    }

    /**
     * @test
     * 
     * Test return an endpoint for deleting a teacher
     *
     * @return void
     */
    public function test_destroy_an_existing_teacher()
    {
        $this->preparePayload();

        $this->instance(
            TeacherRepositoryInterface::class,
            Mockery::mock(TeacherRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doDelete(route('classroom.teachers.destroy', [$this->payload[0]->club_id, $this->payload[0]->id]), $this->admin_token);
        $response->assertStatus(204);
    }
}
