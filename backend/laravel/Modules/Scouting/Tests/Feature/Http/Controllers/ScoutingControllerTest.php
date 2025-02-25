<?php

namespace Modules\Scouting\Tests\Feature\Http\Controllers;

use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Modules\Scouting\Tests\Fixtures\ScoutingControllerFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Modules\Scouting\Entities\Scouting;
use Mockery\MockInterface;
use Tests\ModuleTestCase;
use Mockery;

class ScoutingControllerTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use ScoutingControllerFixturesTrait;

    /**
     * @test
     * Test return an endpoint with a list of the next games 
     * availables to scout by team
     *
     * @return void
     */
    public function test_index_displays_info_of_next_games_to_scout_by_team()
    {
        $this->preparePayload();

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, [])
                    ->once()
                    ->andReturn(collect($this->payload));
            })
        );

        $response = $this->doGet(route('scouting.available.byTeam', $this->payload[0]->competition->team->id), $this->admin_token);
        $response->assertStatus(200);
        $response->assertSee('List of games to scout');
        $response->assertJsonFragment(['match_id' => $this->payload[0]->id]);
        $response->assertJsonFragment(['competition_name' => $this->payload[0]->competition_name]);
        $response->assertJsonFragment(['rival_team' => $this->payload[0]->competitionRivalTeam->rival_team]);
        $response->assertJsonFragment(['name' => $this->payload[0]->competition->team->name]);
        $response->assertJsonFragment(['start_at' => $this->payload[0]->start_at]);
        $response->assertJsonFragment(['match_situation' => $this->payload[0]->match_situation]);
    }

    /**
     * @test
     * Test return an endpoint with a list of the next games 
     * availables to scout by team order by date desc
     *
     * @return void
     */
    public function test_index_displays_info_of_next_games_to_scout_by_team_order_by_date_desc()
    {
        $this->preparePayload();
        $filters = ['orderByDate' => 'DESC'];

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) use ($filters) {
                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, $filters)
                    ->once()
                    ->andReturn(collect($this->payload));
            })
        );

        $response = $this->doGet(route('scouting.available.byTeam', [$this->payload[0]->competition->team->id, 'orderByDate' => $filters['orderByDate']]), $this->admin_token);
        $response->assertSee('List of games to scout');
        $response->assertStatus(200);
        $response->assertJsonPath('data.0.match_id', $this->payload[0]->id);
    }

    /**
     * @test
     * Test return an endpoint with a list of the next games 
     * availables to scout by team order by date asc
     *
     * @return void
     */
    public function test_index_displays_info_of_next_games_to_scout_by_team_order_by_date_asc()
    {
        $this->preparePayload();
        $filters = ['orderByDate' => 'ASC'];

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) use ($filters) {
                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, $filters)
                    ->once()
                    ->andReturn(collect([$this->payload[1], $this->payload[0]]));
            })
        );

        $response = $this->doGet(route('scouting.available.byTeam', [$this->payload[0]->competition->team->id, 'orderByDate' => $filters['orderByDate']]), $this->admin_token);
        $response->assertSee('List of games to scout');
        $response->assertStatus(200);
        $response->assertJsonPath('data.0.match_id', $this->payload[1]->id);
    }

    /**
     * @test
     * Test return an endpoint with a list of the next games 
     * availables to scout by team order by competition desc
     *
     * @return void
     */
    public function test_index_displays_info_of_next_games_to_scout_by_team_order_by_competition_desc()
    {
        $this->preparePayloadMultipleCompetitions();
        $filters = ['orderByCompetition' => 'DESC'];

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) use ($filters) {
                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, $filters)
                    ->once()
                    ->andReturn(collect([$this->payload[2], $this->payload[3], $this->payload[0], $this->payload[1]]));
            })
        );

        $response = $this->doGet(
            route(
                'scouting.available.byTeam',
                [
                    $this->payload[0]->competition->team->id,
                    'orderByCompetition' => $filters['orderByCompetition']
                ]
            ),
            $this->admin_token
        );

        $response->assertSee('List of games to scout');
        $response->assertStatus(200);
        $response->assertJsonPath('data.0.competition_name', $this->payload[2]->competition_name);
        $response->assertJsonPath('data.1.competition_name', $this->payload[2]->competition_name);
        $response->assertJsonPath('data.2.competition_name', $this->payload[0]->competition_name);
        $response->assertJsonPath('data.3.competition_name', $this->payload[0]->competition_name);
    }

    /**
     * @test
     * Test return an endpoint with a list of the next games 
     * availables to scout by team order by competition asc
     *
     * @return void
     */
    public function test_index_displays_info_of_next_games_to_scout_by_team_order_by_competition_asc()
    {
        $this->preparePayloadMultipleCompetitions();
        $filters = ['orderByCompetition' => 'DESC'];

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) use ($filters) {
                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, $filters)
                    ->once()
                    ->andReturn(collect([$this->payload[0], $this->payload[1], $this->payload[2], $this->payload[3]]));
            })
        );

        $response = $this->doGet(
            route(
                'scouting.available.byTeam',
                [
                    $this->payload[0]->competition->team->id,
                    'orderByCompetition' => $filters['orderByCompetition']
                ]
            ),
            $this->admin_token
        );

        $response->assertSee('List of games to scout');
        $response->assertStatus(200);
        $response->assertJsonPath('data.0.competition_name', $this->payload[0]->competition_name);
        $response->assertJsonPath('data.1.competition_name', $this->payload[0]->competition_name);
        $response->assertJsonPath('data.2.competition_name', $this->payload[2]->competition_name);
        $response->assertJsonPath('data.3.competition_name', $this->payload[2]->competition_name);
    }

    /**
     * @test
     * Test return an endpoint with a list of the next games 
     * availables to scout by team filtered by date
     *
     * @return void
     */
    public function test_index_displays_info_of_next_games_to_scout_by_team_filter_by_date()
    {
        $this->preparePayload();
        $filters1 = ['filterByDate' => '3021-07-14'];
        $filters2 = ['filterByDate' => '3021-07-15'];

        // Testing with a date that has all the records
        $count = count($this->payload);

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) use ($filters1, $filters2) {
                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, $filters1)
                    ->once()
                    ->andReturn(collect([$this->payload[0], $this->payload[1]]));

                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, $filters2)
                    ->once()
                    ->andReturn(collect([$this->payload[0]]));
            })
        );

        $response = $this->doGet(
            route(
                'scouting.available.byTeam',
                [
                    $this->payload[0]->competition->team->id,
                    'filterByDate' => $filters1['filterByDate']
                ]
            ),
            $this->admin_token
        );

        $response->assertSee('List of games to scout');
        $response->assertStatus(200);
        $response->assertJsonCount($count, 'data');

        // Testing with a date that has just 1 record
        $count = 1;

        $response = $this->doGet(
            route(
                'scouting.available.byTeam',
                [
                    $this->payload[0]->competition->team->id,
                    'filterByDate' => $filters2['filterByDate']
                ]
            ),
            $this->admin_token
        );

        $response->assertSee('List of games to scout');
        $response->assertStatus(200);
        $response->assertJsonCount($count, 'data');
    }

    /**
     * @test
     * Test return an endpoint with a list of the next games 
     * availables to scout by team filtered by date
     *
     * @return void
     */
    public function test_index_displays_info_of_next_games_to_scout_by_team_filter_by_competition()
    {
        $this->preparePayloadMultipleCompetitions();
        $filters1 = ['filterByCompetition' => $this->payload[0]->competition->name];
        $filters2 = ['filterByCompetition' => $this->payload[2]->competition->name];

        // Testing with competition A
        $count = 2;

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) use ($filters1, $filters2) {
                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, $filters1)
                    ->once()
                    ->andReturn(collect([$this->payload[0], $this->payload[1]]));

                $mock->shouldReceive('findAllNextMatchesToScoutByTeam')
                    ->with($this->payload[0]->competition->team->id, $filters2)
                    ->once()
                    ->andReturn(collect([$this->payload[2], $this->payload[3]]));
            })
        );

        $response = $this->doGet(
            route(
                'scouting.available.byTeam',
                [
                    $this->payload[0]->competition->team->id,
                    'filterByCompetition' => $filters1['filterByCompetition']
                ]
            ),
            $this->admin_token
        );

        $response->assertSee('List of games to scout');
        $response->assertStatus(200);
        $response->assertJsonCount($count, 'data');
        $response->assertJsonPath('data.0.competition_name', $this->payload[0]->competition->name);
        $response->assertJsonPath('data.1.competition_name', $this->payload[0]->competition->name);

        // Testing with competition B
        $count = 2;

        $response = $this->doGet(
            route(
                'scouting.available.byTeam',
                [
                    $this->payload[0]->competition->team->id,
                    'filterByCompetition' => $filters2['filterByCompetition']
                ]
            ),
            $this->admin_token
        );

        $response->assertSee('List of games to scout');
        $response->assertStatus(200);
        $response->assertJsonCount($count, 'data');
        $response->assertJsonPath('data.0.competition_name', $this->payload[2]->competition->name);
        $response->assertJsonPath('data.1.competition_name', $this->payload[2]->competition->name);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying
     * to start a scouting using a competition
     * match that not exist
     *
     * @return void
     */
    public function test_i_can_not_start_a_scouting_for_a_competition_match_that_not_exist()
    {
        $this->preparePayload();
        $notExistingId = 999999;

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) use ($notExistingId) {
                $mock->shouldReceive('find')
                    ->with($notExistingId)
                    ->once()
                    ->andReturn(null);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.start',
                $notExistingId
            ),
            [],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertSee(sprintf('The competition match %s does not exist', $notExistingId));
    }

    /**
     * @test 
     *
     * Test returns an error response when trying
     * to start a scouting that already started
     * @return void
     */
    public function test_i_can_not_start_a_scouting_that_already_started()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_STARTED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );
        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.start',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertSee(sprintf('The scouting for the match %s has already started', $this->payload->competition_match_id));
    }

    /**
     * @test 
     *
     * Test returns an error response when trying
     * to start a scouting that already finished
     * @return void
     */
    public function test_i_can_not_start_a_scouting_that_already_finished()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_FINISHED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );
        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.start',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertSee(sprintf('The scouting for the match %s has been finished', $this->payload->competition_match_id));
    }

    /**
     * @test 
     *
     * Test returns an success response when trying
     * to start a scouting on a competition
     * match that has not being created
     * @return void
     */
    public function test_i_can_start_a_scouting()
    {
        $this->preparePayload();

        $response = $this->doPost(
            route(
                'scouting.status.start',
                $this->payload[0]->id
            ),
            [],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('Scouting started');
    }

    /**
     * @test
     *
     * Test returns an success response when trying
     * to start a scouting that has not being
     * started
     * @return void
     */
    public function test_i_can_start_a_scouting_that_exist_but_it_has_not_started()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_NOT_STARTED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);
            })
        );
        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->id)
                    ->once()
                    ->andReturn($this->payload);

                $mock->shouldReceive('changeStatus')
                    ->with($this->payload, Scouting::STATUS_STARTED)
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.start',
                $this->payload->competition_match_id
            ),
            [],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('Scouting started');
    }

    /**
     * @test
     * 
     * Test returns an error response when trying
     * to pause a scouting using a competition
     * match that not exist
     *
     * @return void
     */
    public function test_i_can_not_pause_a_scouting_for_a_competition_match_that_not_exist()
    {
        $this->preparePayload();
        $notExistingId = 999999;

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) use ($notExistingId) {
                $mock->shouldReceive('find')
                    ->with($notExistingId)
                    ->once()
                    ->andReturn(null);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.pause',
                $notExistingId
            ),
            ['in_game_time' => '40:00'],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertSee(sprintf('The competition match %s does not exist', $notExistingId));
    }

    /**
     * @test 
     *
     * Test returns an error response when trying
     * to pause a scouting that is already paused
     * @return void
     */
    public function test_i_can_not_pause_a_scouting_that_already_pause()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_PAUSED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.pause',
                $this->payload->competition_match_id
            ),
            ['in_game_time' => '40:00'],
            $this->admin_token
        );

        $response->assertSee(sprintf('The scouting for the match %s is already paused', $this->payload->competition_match_id));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test 
     *
     * Test returns an error response when trying
     * to pause a scouting that has not started
     * @return void
     */
    public function test_i_can_not_pause_a_scouting_that_has_not_being_started()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_NOT_STARTED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.pause',
                $this->payload->competition_match_id
            ),
            ['in_game_time' => '40:00'],
            $this->admin_token
        );

        $response->assertSee(sprintf('The scouting for the match %s has not been started', $this->payload->competition_match_id));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     *
     * Test returns an error response when trying
     * to pause a scouting that has finished
     * @return void
     */
    public function test_i_can_not_pause_a_scouting_that_has_finished()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_FINISHED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.pause',
                $this->payload->competition_match_id
            ),
            ['in_game_time' => '40:00'],
            $this->admin_token
        );

        $response->assertSee(sprintf('The scouting for the match %s has been finished', $this->payload->competition_match_id));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     *
     * Test returns an success response when trying
     * to pause a scouting that has already started
     * @return void
     */
    public function test_i_can_pause_a_scouting()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_STARTED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);

                $mock->shouldReceive('changeStatus')
                    ->with($this->payload, Scouting::STATUS_PAUSED, '40:00')
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.pause',
                $this->payload->competition_match_id
            ),
            ['in_game_time' => '40:00'],
            $this->admin_token
        );

        $response->assertSee('Scouting paused');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying
     * to start a scouting using a competition
     * match that not exist
     *
     * @return void
     */
    public function test_i_can_not_finish_a_scouting_for_a_competition_match_that_not_exist()
    {
        $this->preparePayload();
        $notExistingId = 999999;

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) use ($notExistingId) {
                $mock->shouldReceive('find')
                    ->with($notExistingId)
                    ->once()
                    ->andReturn(null);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.finish',
                $notExistingId
            ),
            ['in_game_time' => '90:00'],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertSee(sprintf('The competition match %s does not exist', $notExistingId));
    }

    /**
     * @test 
     *
     * Test returns an error response when trying
     * to finish a scouting that already started
     * @return void
     */
    public function test_i_can_not_finish_a_scouting_that_has_not_started()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_NOT_STARTED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.finish',
                $this->payload->competition_match_id
            ),
            ['in_game_time' => '90:00'],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertSee(sprintf('The scouting for the match %s has not been started', $this->payload->competition_match_id));
    }

    /**
     * @test
     *
     * Test returns an error response when trying
     * to finish a scouting that is paused
     * @return void
     */
    public function test_i_can_not_finish_a_scouting_that_is_paused()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_PAUSED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.finish',
                $this->payload->competition_match_id
            ),
            ['in_game_time' => '90:00'],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertSee(sprintf('The scouting for the match %s is paused', $this->payload->competition_match_id));
    }

    /**
     * @test 
     *
     * Test returns an error response when trying
     * to finish a scouting that is finished
     * @return void
     */
    public function test_i_can_not_finish_a_scouting_that_is_already_finished()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_FINISHED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.finish',
                $this->payload->competition_match_id
            ),
            ['in_game_time' => '90:00'],
            $this->admin_token
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertSee(sprintf('The scouting for the match %s has already finished', $this->payload->competition_match_id));
    }

    /**
     * @test
     *
     * Test returns an success response when trying
     * to finish a scouting that has already started
     * @return void
     */
    public function test_i_can_finish_a_scouting()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_STARTED);

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);

                $mock->shouldReceive('changeStatus')
                    ->with($this->payload, Scouting::STATUS_FINISHED, '90:00')
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doPost(
            route(
                'scouting.status.finish',
                $this->payload->competition_match_id
            ),
            ['in_game_time' => '90:00'],
            $this->admin_token
        );

        $response->assertSee('Scouting finished');
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     *
     * Test returns an success response when trying
     * to retrieve the status of a finished scouting
     * @return void
     */
    public function test_i_can_get_status_of_a_finish_a_scouting()
    {
        $this->preparePayloadWithScouting(Scouting::STATUS_FINISHED, '90:00');

        $this->instance(
            CompetitionMatchRepositoryInterface::class,
            Mockery::mock(CompetitionMatchRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('find')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload->competitionMatch);
            })
        );

        $this->instance(
            ScoutingRepositoryInterface::class,
            Mockery::mock(ScoutingRepositoryInterface::class, function (MockInterface $mock) {
                $mock->shouldReceive('findOneBy')
                    ->with(['competition_match_id' => $this->payload->competition_match_id])
                    ->once()
                    ->andReturn($this->payload);

                $mock->shouldReceive('findOrCreateScout')
                    ->with($this->payload->competition_match_id)
                    ->once()
                    ->andReturn($this->payload);

                $mock->shouldReceive('changeStatus')
                    ->with($this->payload, Scouting::STATUS_FINISHED, '90:00')
                    ->once()
                    ->andReturn($this->payload);
            })
        );

        $response = $this->doGet(
            route(
                'scouting.show',
                $this->payload->competition_match_id
            ),
            $this->admin_token
        );

        $response->assertSee('90:00');
        $response->assertStatus(Response::HTTP_OK);
    }
}
