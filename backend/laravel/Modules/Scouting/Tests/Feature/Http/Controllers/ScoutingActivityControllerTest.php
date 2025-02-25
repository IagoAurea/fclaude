<?php

namespace Modules\Scouting\Tests\Feature\Http\Controllers;

use Modules\Scouting\Repositories\Interfaces\ScoutingActivityRepositoryInterface;
use Modules\Scouting\Tests\Fixtures\ScoutingActivityControllerFixturesTrait;
use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\Action;
use Mockery\MockInterface;
use Tests\ModuleTestCase;
use Carbon\Carbon;
use Mockery;

class ScoutingActivityControllerTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use ScoutingActivityControllerFixturesTrait;

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * store an scouting activity on a competition
     * match that not exist
     *
     * @return void
     */
    public function test_i_can_not_store_a_scouting_activity_with_a_competition_match_that_not_exist()
    {
        $this->preparePayload();

        $notExisitingId = 9999999;
        $payload = [
            'scouting_id' => $this->payload->id,
            'action_id' => Action::factory()->create()->id,
            'in_game_time' => Carbon::now()
        ];

        $response = $this->doPost(
            route(
                'scouting.activity.store',
                $notExisitingId
            ),
            $payload,
            $this->admin_token
        );

        $response->assertSee(sprintf('The competition match %s does not exist', $notExisitingId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * store an scouting activity on a not started
     * scouting
     *
     * @return void
     */
    public function test_i_can_not_store_a_scouting_activity_on_a_not_started_scouting()
    {
        $this->preparePayload(Scouting::STATUS_NOT_STARTED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $payload = [
            'scouting_id' => $this->payload->id,
            'action_id' => Action::factory()->create()->id,
            'in_game_time' => Carbon::now()
        ];

        $response = $this->doPost(
            route(
                'scouting.activity.store',
                $this->payload->competition_match_id
            ),
            $payload,
            $this->admin_token
        );

        $response->assertSee(sprintf('The scouting for the match %s has not been started', $this->payload->competition_match_id));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * store an scouting activity on a paused
     * scouting
     *
     * @return void
     */
    public function test_i_can_not_store_a_scouting_activity_on_a_paused_scouting()
    {
        $this->preparePayload(Scouting::STATUS_PAUSED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $payload = [
            'scouting_id' => $this->payload->id,
            'action_id' => Action::factory()->create()->id,
            'in_game_time' => Carbon::now()
        ];

        $response = $this->doPost(
            route(
                'scouting.activity.store',
                $this->payload->competition_match_id
            ),
            $payload,
            $this->admin_token
        );

        $response->assertSee(sprintf('The scouting for the match %s has been paused', $this->payload->competition_match_id));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * store an scouting activity on a finished
     * scouting
     *
     * @return void
     */
    public function test_i_can_not_store_a_scouting_activity_on_a_finished_scouting()
    {
        $this->preparePayload(Scouting::STATUS_FINISHED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $payload = [
            'scouting_id' => $this->payload->id,
            'action_id' => Action::factory()->create()->id,
            'in_game_time' => Carbon::now()
        ];

        $response = $this->doPost(
            route(
                'scouting.activity.store',
                $this->payload->competition_match_id
            ),
            $payload,
            $this->admin_token
        );

        $response->assertSee(sprintf('The scouting for the match %s has already finished', $this->payload->competition_match_id));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns a success response after creating a
     * scouting activity
     *
     * @return void
     */
    public function test_i_can_store_a_scouting_activity()
    {
        $this->preparePayload(Scouting::STATUS_STARTED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $payload = [
            'scouting_id' => $this->payload->id,
            'action_id' => Action::factory()->create()->id,
            'in_game_time' => Carbon::now()
        ];

        $response = $this->doPost(
            route(
                'scouting.activity.store',
                $this->payload->competition_match_id
            ),
            $payload,
            $this->admin_token
        );

        $response->assertSee('Scouting activity created');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns a success response after creating a
     * scouting activity with a player assignated
     *
     * @return void
     */
    public function test_i_can_store_a_scouting_activity_with_a_player_assignated()
    {
        $this->preparePayload(Scouting::STATUS_STARTED);

        $player = $this->payload
            ->competitionMatch
            ->competition
            ->team
            ->players
            ->first();

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $payload = [
            'scouting_id' => $this->payload->id,
            'player_id' => $player->id,
            'action_id' => Action::factory()->create()->id,
            'in_game_time' => Carbon::now()
        ];

        $response = $this->doPost(
            route(
                'scouting.activity.store',
                $this->payload->competition_match_id
            ),
            $payload,
            $this->admin_token
        );

        $response->assertSee('Scouting activity created');
        $response->assertJsonFragment(['player_id' => $player->id]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns a success response after creating a
     * scouting activity for a rival team
     *
     * @return void
     */
    public function test_i_can_store_a_scouting_activity_for_a_rival_team()
    {
        $this->preparePayload(Scouting::STATUS_STARTED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $payload = [
            'scouting_id' => $this->payload->id,
            'action_id' => Action::factory()->create(['rival_team_action' => true])->id,
            'in_game_time' => Carbon::now()
        ];

        $response = $this->doPost(
            route(
                'scouting.activity.store',
                $this->payload->competition_match_id
            ),
            $payload,
            $this->admin_token
        );

        $response->assertSee('Scouting activity created');
        $response->assertJsonFragment(['rival_team_action' => true]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * store an scouting activity on a competition
     * match that not exist
     *
     * @return void
     */
    public function test_i_can_not_list_scouting_activities_with_a_competition_match_that_not_exist()
    {
        $this->preparePayload();

        $notExisitingId = 9999999;

        $response = $this->doGet(
            route(
                'scouting.activity.index',
                $notExisitingId
            ),
            $this->admin_token
        );

        $response->assertSee(sprintf('The competition match %s does not exist', $notExisitingId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns a success response after requesting
     * a list of scouting activities
     *
     * @return void
     */
    public function test_i_can_see_a_list_of_scouting_activities()
    {
        $this->preparePayloadWithActivities();

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload[0]->scouting->competition_match_id)
                    ->once()
                    ->andReturn($this->payload[0]->scouting);
            })
        );

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['scouting_id' => $this->payload[0]->scouting_id, 'status' => 1])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doGet(
            route(
                'scouting.activity.index',
                $this->payload[0]->scouting->competition_match_id
            ),
            $this->admin_token
        );

        $response->assertSee('List of scouting activities');
        $response->assertJsonCount(2, 'data');
        $response->assertSee($this->payload[0]->action->name);
        $response->assertSee($this->payload[1]->action->name);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * delete an scouting activity on a competition
     * match that not exist
     *
     * @return void
     */
    public function test_i_can_not_delete_a_scouting_activity_that_not_exist()
    {
        $this->preparePayload();

        $notExisitingId = 9999999;

        $response = $this->doDelete(
            route(
                'scouting.activity.destroy',
                $notExisitingId
            ),
            $this->admin_token
        );

        $response->assertSee(sprintf('The activity %s does not exist', $notExisitingId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns a success response after 
     * trying to delete a scouting activity
     *
     * @return void
     */
    public function test_i_can_destroy_a_scouting_activity()
    {
        $this->preparePayloadWithActivities();

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doDelete(
            route(
                'scouting.activity.destroy',
                $this->payload[0]->id
            ),
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * update an scouting activity on a competition
     * match that not exist
     *
     * @return void
     */
    public function test_i_can_not_update_a_scouting_activity_that_not_exist()
    {
        $this->preparePayload();

        $notExisitingId = 9999999;

        $response = $this->doPut(
            route(
                'scouting.activity.update',
                $notExisitingId
            ),
            [],
            $this->admin_token
        );

        $response->assertSee(sprintf('The activity %s does not exist', $notExisitingId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * update an scouting activity on paused scouting
     *
     * @return void
     */
    public function test_i_can_not_update_a_scouting_activity_with_a_paused_scouting()
    {
        $this->preparePayloadWithActivities(Scouting::STATUS_PAUSED);

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doPut(
            route(
                'scouting.activity.update',
                $this->payload[0]->id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee(sprintf('This scouting is paused'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * update an scouting activity on paused scouting
     *
     * @return void
     */
    public function test_i_can_not_update_a_scouting_activity_with_a_finished_scouting()
    {
        $this->preparePayloadWithActivities(Scouting::STATUS_FINISHED);

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $response = $this->doPut(
            route(
                'scouting.activity.update',
                $this->payload[0]->id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee(sprintf('This scouting has already finished'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns a success response after 
     * trying to update a scouting activity
     *
     * @return void
     */
    public function test_i_can_update_a_scouting_activity()
    {
        $this->preparePayloadWithActivities();

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['id' => $this->payload[0]->id])
                    ->once()
                    ->andReturn($this->payload[0]);
            })
        );

        $payload = [
            'action_id' => Action::factory()->create()->id
        ];

        $response = $this->doPut(
            route(
                'scouting.activity.update',
                $this->payload[0]->id
            ),
            $payload,
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns an error response after trying to
     * undo the last scouting activity if there
     * are no activities left
     *
     * @return void
     */
    public function test_i_can_not_undo_the_last_scouting_activity_if_there_are_no_activities()
    {
        $this->preparePayload();

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['scouting_id' => $this->payload->id, 'status' => 1])
                    ->once()
                    ->andReturn(collect([]));
            })
        );

        $response = $this->doPost(
            route(
                'scouting.activity.undo',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee('There are no activities to undo');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns an error response after trying to
     * redo the last scouting activity if there
     * are no activities left to redo
     *
     * @return void
     */
    public function test_i_can_not_redo_the_last_scouting_activity_if_there_are_no_activities()
    {
        $this->preparePayload();

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['scouting_id' => $this->payload->id, 'status' => 0])
                    ->once()
                    ->andReturn(collect([]));
            })
        );

        $response = $this->doPost(
            route(
                'scouting.activity.redo',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee('There are no activities to redo');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns an error response after trying to
     * undo the last scouting activity if the
     * scouting status is paused
     *
     * @return void
     */
    public function test_i_can_not_undo_the_last_scouting_activity_if_the_scouting_status_is_paused()
    {
        $this->preparePayload(Scouting::STATUS_PAUSED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.activity.undo',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee('This scouting is paused');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns an error response after trying to
     * redo the last scouting activity if the
     * scouting status is paused
     *
     * @return void
     */
    public function test_i_can_not_redo_the_last_scouting_activity_if_the_scouting_status_is_paused()
    {
        $this->preparePayload(Scouting::STATUS_PAUSED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.activity.redo',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee('This scouting is paused');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns an error response after trying to
     * undo the last scouting activity if the
     * scouting status is finished
     *
     * @return void
     */
    public function test_i_can_not_undo_the_last_scouting_activity_if_the_scouting_status_is_finished()
    {
        $this->preparePayload(Scouting::STATUS_FINISHED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.activity.undo',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee('This scouting has already finished');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns an error response after trying to
     * redo the last scouting activity if the
     * scouting status is finished
     *
     * @return void
     */
    public function test_i_can_not_redo_the_last_scouting_activity_if_the_scouting_status_is_finished()
    {
        $this->preparePayload(Scouting::STATUS_FINISHED);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.activity.redo',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee('This scouting has already finished');
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     * 
     * Test returns an error response after trying to
     * undo the last scouting activity if the
     * competition match does not exist
     *
     * @return void
     */
    public function test_i_can_not_undo_the_last_scouting_activity_if_the_competition_match_does_not_exist()
    {
        $this->preparePayload();
        $notExisitingId = 9999999;

        $response = $this->doPost(
            route(
                'scouting.activity.undo',
                $notExisitingId
            ),
            [],
            $this->admin_token
        );

        $response->assertSee(sprintf('The competition match %s does not exist', $notExisitingId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns an error response after trying to
     * redo the last scouting activity if the
     * competition match does not exist
     *
     * @return void
     */
    public function test_i_can_not_redo_the_last_scouting_activity_if_the_competition_match_does_not_exist()
    {
        $this->preparePayload();
        $notExisitingId = 9999999;

        $response = $this->doPost(
            route(
                'scouting.activity.redo',
                $notExisitingId
            ),
            [],
            $this->admin_token
        );

        $response->assertSee(sprintf('The competition match %s does not exist', $notExisitingId));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns an success response after trying
     * to undo the last scouting activity
     *
     * @return void
     */
    public function test_i_can_undo_the_last_scouting_activity()
    {
        $this->preparePayloadWithActivities();

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload[1]->scouting->competition_match_id)
                    ->once()
                    ->andReturn($this->payload[1]->scouting);
            })
        );

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['scouting_id' => $this->payload[1]->scouting->id, 'status' => 1])
                    ->once()
                    ->andReturn(collect($this->payload));
            })
        );

        $response = $this->doPost(
            route(
                'scouting.activity.undo',
                $this->payload[1]->scouting->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee('Activity removed');
        $response->assertSee($this->payload[0]->action->name);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns an success response after trying
     * to redo the last scouting activity
     *
     * @return void
     */
    public function test_i_can_redo_the_last_scouting_activity()
    {
        $this->preparePayloadWithActivities(Scouting::STATUS_STARTED, false);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload[1]->scouting->competition_match_id)
                    ->once()
                    ->andReturn($this->payload[1]->scouting);
            })
        );

        $this->instance(
            ScoutingActivityRepositoryInterface::class,
            Mockery::mock(ScoutingActivityRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findBy')
                    ->with(['scouting_id' => $this->payload[1]->scouting->id, 'status' => 0])
                    ->once()
                    ->andReturn(collect([$this->payload[1]]));
            })
        );

        $response = $this->doPost(
            route(
                'scouting.activity.redo',
                $this->payload[1]->scouting->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertSee('Activity redone');
        $response->assertSee($this->payload[1]->action->name);
        $response->assertStatus(Response::HTTP_OK);
    }
}
