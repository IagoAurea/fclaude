<?php

namespace Modules\Scouting\Tests\Unit\Services;

use Modules\Scouting\Tests\Fixtures\BaseballMatchFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Scouting\Processors\ResultsProcessor;
use Modules\Scouting\Processors\SideEffects\Baseball\Errors;
use Modules\Scouting\Processors\SideEffects\Baseball\Strikes;
use Modules\Scouting\Processors\SideEffects\Baseball\Walks;
use Tests\ModuleTestCase;

class BaseballResultProcessorTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use BaseballMatchFixturesTrait;

    /**
     * @test
     * 
     * * Test the results of a baseball match that doesnt have
     * * any goal activities recorded will return 0 to 0
     * * as the score result
     */
    public function a_baseball_match_that_doesnt_record_runs_activities_returns_0_0_as_score_result()
    {
        $this->preparePayloadWithNoRuns();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['score']['own'] == 0);
        $this->assertTrue($result['score']['rival'] == 0);
    }

    /**
     * @test
     * 
     * * Test the results of a football match that doesnt have
     * * any goal activities recorded will return 0 to 0
     * * as the score result
     */
    public function a_baseball_match_that_doesnt_record_runs_activities_returns_1_1_as_score_result()
    {
        $this->preparePayloadWith1RunsForEachTeam();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['score']['own'] == 1);
        $this->assertTrue($result['score']['rival'] == 1);
    }

    /**
     * @test
     * 
     * * Test the results of a baseball match that doesnt have
     * * any strike activities recorded will return 1
     * * as the strike score
     */
    public function a_baseball_match_that_record_strike_activities_returns_1_strike_as_score_result()
    {
        $this->preparePayloadWith1Strike();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->scouting->competition_match_id);

        $this->assertTrue($result['score']['strikes'] == 1);
    }

    /**
     * @test
     * 
     * * Test the results of a baseball match that
     * * have 3 consecutive strikes in a turn
     */
    public function a_baseball_match_that_record_3_strikes_in_a_turn_returns_1_out_as_score_result()
    {
        $this->preparePayloadWith3Strikes();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['strikes'] == 0);
        $this->assertTrue($result['score']['outs'] == 1);
        $this->assertTrue($result['statistics'][Strikes::STATISTIC_NAME] == 3);
    }

    /**
     * @test
     * 
     * * Test the results of a baseball match that doesnt have
     * * any ball activities recorded will return 1
     * * as the ball score
     */
    public function a_baseball_match_that_record_ball_activities_returns_1_ball_as_score_result()
    {
        $this->preparePayloadWith1Ball();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['balls'] == 1);
    }

    /**
     * @test
     * 
     * * Test the results of a baseball match that
     * * have 4 consecutive balls in a turn
     */
    public function a_baseball_match_that_record_4_balls_in_a_turn_returns_1_walk_as_score_result()
    {
        $this->preparePayloadWith4Ball();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['balls'] == 0);
        $this->assertTrue($result['statistics'][Walks::STATISTIC_NAME] == 1);
    }

    /**
     * @test
     * 
     * * Test the results of a baseball match that
     * * have 1 error recorded in a turn
     */
    public function a_baseball_match_that_record_1_errors_in_a_turn_returns_1_error_as_score_result()
    {
        $this->preparePayloadWith1Error();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own_errors'] == 1);
        $this->assertTrue($result['statistics'][Errors::STATISTIC_NAME_OWN] == 1);
    }

    /**
     * @test
     * 
     * * Test the results of a baseball match that
     * * have 4 errors in a turn
     */
    public function a_baseball_match_that_record_4_errors_in_a_turn_returns_4_error_as_score_result()
    {
        $this->preparePayloadWith4Errors();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own_errors'] == 4);
        $this->assertTrue($result['statistics'][Errors::STATISTIC_NAME_OWN] == 4);
    }

    /**
     * @test
     * 
     * * Test the results of a baseball match that
     * * have 3 outs in a turn
     */
    public function a_baseball_match_that_record_3_outs_in_a_turn_current_change_the_inning()
    {
        $this->preparePayloadWith3Outs();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['current_inning'] == '1_down');
    }
}
