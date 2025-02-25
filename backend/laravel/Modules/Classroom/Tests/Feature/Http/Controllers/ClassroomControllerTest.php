<?php

namespace Modules\Classroom\Tests\Feature\Http\Controllers;

use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Classroom\Tests\Fixtures\ClassroomControllerFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Mockery\MockInterface;
use Tests\ModuleTestCase;
use Mockery;

class ClassroomControllerTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use ClassroomControllerFixturesTrait;

    /**
     * @test
     * 
     * Test return an endpoint with a list of the ages
     *
     * @return void
     */
    public function test_index_displays_list_of_classrooms()
    {
        $this->preparePayload();

        $this->instance(
            ClassroomRepositoryInterface::class,
            Mockery::mock(ClassroomRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['club_id' => $this->payload[0]->club_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doGet(route('classroom.classrooms.index', [$this->payload[0]->club_id]), $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee('List of classrooms');
        $response->assertJsonFragment(['name' => $this->payload[0]->name]);
    }

    /**
     * @test
     * 
     * Test return an endpoint with a given classroom
     *
     * @return void
     */
    public function test_show_displays_a_given_classrooms()
    {
        $this->preparePayload();

        $this->instance(
            ClassroomRepositoryInterface::class,
            Mockery::mock(ClassroomRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doGet(route('classroom.classrooms.show', [$this->payload[0]->club_id, $this->payload[0]->id]), $this->admin_token);
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $this->payload[0]->name]);
    }

    /**
     * @test
     * 
     * Test return an endpoint for store a new classroom
     *
     * @return void
     */
    public function test_store_a_new_classroom()
    {
        $this->preparePayload();

        $this->instance(
            ClassroomRepositoryInterface::class,
            Mockery::mock(ClassroomRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('create')
                    ->with([
                        'name' => $this->payload[0]->name,
                        'scholar_year' => $this->payload[0]->scholar_year,
                        'age_id' => $this->payload[0]->age_id,
                        'physical_teacher_id' => $this->payload[0]->physical_teacher_id,
                        'tutor_id' => $this->payload[0]->tutor_id,
                        'subject_id' => $this->payload[0]->subject_id,
                        'club_id' => $this->payload[0]->club_id
                    ])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doPost(route('classroom.classrooms.store', [$this->payload[0]->club_id]), [
            'name' => $this->payload[0]->name,
            'scholar_year' => $this->payload[0]->scholar_year,
            'age_id' => $this->payload[0]->age_id,
            'physical_teacher_id' => $this->payload[0]->physical_teacher_id,
            'tutor_id' => $this->payload[0]->tutor_id,
            'subject_id' => $this->payload[0]->subject_id
        ], $this->admin_token);
        $response->assertStatus(201);
        $response->assertSee(sprintf('Classroom created'));
    }

    /**
     * @test
     * 
     * Test return an endpoint for updating an existing classroom
     *
     * @return void
     */
    public function test_update_an_existing_classroom()
    {
        $this->preparePayload();

        $this->instance(
            ClassroomRepositoryInterface::class,
            Mockery::mock(ClassroomRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $payload = [
            'name' => 'modified',
        ];


        $response = $this->doPut(route('classroom.classrooms.update', [$this->payload[0]->club_id, $this->payload[0]->id]), $payload, $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee(sprintf('Classroom updated'));
    }

    /**
     * @test
     * 
     * Test return an endpoint for deleting a classroom
     *
     * @return void
     */
    public function test_destroy_an_existing_classroom()
    {
        $this->preparePayload();

        $this->instance(
            ClassroomRepositoryInterface::class,
            Mockery::mock(ClassroomRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['club_id' => $this->payload[0]->club_id, 'id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doDelete(route('classroom.classrooms.destroy', [$this->payload[0]->club_id, $this->payload[0]->id]), $this->admin_token);
        $response->assertStatus(204);
    }
}
