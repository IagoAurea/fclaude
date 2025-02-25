<?php

namespace Modules\Scouting\Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Response;
use Tests\ModuleTestCase;
use Modules\Scouting\Tests\Fixtures\FootballMatchFixturesTrait;
use Modules\Scouting\Tests\Fixtures\ScoutingResultsControllerFixturesTrait;

class ScoutingResultsControllerTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use FootballMatchFixturesTrait;
    use ScoutingResultsControllerFixturesTrait;

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * retrieve the results of a competition
     * match that not exist
     *
     * @return void
     */
    public function test_i_can_not_return_the_results_of_a_competition_match_that_not_exist()
    {
        $competition_match_id = 9999999999;
        $response = $this->doGet(
            route(
                'scouting.results.byCompetitionMatch',
                $competition_match_id
            ),
            $this->admin_token
        );

        $response->assertSee(sprintf('The competition match %s does not exist', $competition_match_id));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     * 
     * Test returns an error response when trying to
     * retrieve the results of a competition
     * match with a sport that is not
     * configured
     *
     * @return void
     */
    public function test_i_can_not_return_the_results_of_a_competition_match_that_has_not_configured_the_sport()
    {
        $this->preparePayload();

        $competition_match_id = $this->payload[0]->scouting->competition_match_id;;
        $response = $this->doGet(
            route(
                'scouting.results.byCompetitionMatch',
                $competition_match_id
            ),
            $this->admin_token
        );

        $response->assertSee(sprintf('The sport of this scouting (%s) has not being configured to process the scouting activities associated', $this->payload[1]));
    }

    /**
     * @test
     * 
     * Test returns a success response when trying to
     * retrieve the results of a competition
     * match that exist
     *
     * @return void
     */
    public function test_i_can_return_the_results_of_a_competition_match()
    {
        $this->preparePayloadWithNoGoals();

        $competition_match_id = $this->payload[0]->scouting->competition_match_id;
        $response = $this->doGet(
            route(
                'scouting.results.byCompetitionMatch',
                $competition_match_id
            ),
            $this->admin_token
        );

        $response->assertSee(sprintf('Scouting results for match %s', $competition_match_id));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns a success response when trying to
     * retrieve the actions of the players by
     * a given competition
     *
     * @return void
     */
    public function test_i_can_return_the_results_of_a_player_by_competition_match()
    {
        $this->preparePayloadWithPlayerActivities();

        $competition_match_id = $this->payload[0]->scouting->competition_match_id;
        $response = $this->doGet(
            route(
                'scouting.results.player.index',
                $competition_match_id
            ),
            $this->admin_token
        );

        $response->assertSee(sprintf('Player activities for match %s grouped by players', $competition_match_id));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns a success response when trying to
     * retrieve the actions of a given player by
     * on the last competition match
     *
     * @return void
     */
    public function test_i_can_return_the_results_of_a_player_by_the_last_competition_match()
    {
        $this->preparePayloadWithPlayerActivities();

        $competition_match_id = $this->payload[0]->scouting->competition_match_id;
        $response = $this->doGet(
            route(
                'scouting.results.player.lastGameActions',
                $this->payload[2]
            ),
            $this->admin_token
        );

        $response->assertSee(sprintf('Player activities for match %s', $competition_match_id));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * 
     * Test returns a success response when trying to
     * retrieve the actions of a given player and
     * a given competition match
     *
     * @return void
     */
    public function test_i_can_return_the_results_of_a_player_by_a_given_competition_match()
    {
        $this->preparePayloadWithPlayerActivities();

        $competition_match_id = $this->payload[0]->scouting->competition_match_id;
        $response = $this->doGet(
            route(
                'scouting.results.player.show',
                [
                    $competition_match_id,
                    $this->payload[2]
                ]
            ),
            $this->admin_token
        );

        $response->assertSee(sprintf('Player activities for match %s', $competition_match_id));
        $response->assertStatus(Response::HTTP_OK);
    }
}
