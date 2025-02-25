<?php

namespace Modules\Scouting\Tests\Unit\Services;

use Modules\Scouting\Tests\Fixtures\VolleyballMatchFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Scouting\Processors\ResultsProcessor;
use Modules\Scouting\Processors\Score\VolleyballScoringSystem;
use Tests\ModuleTestCase;

class VolleyballResultProcessorTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use VolleyballMatchFixturesTrait;

    /**
     * @test
     * 
     * Test a set of a volleyball match goes
     * up until the point limit is reached
     */
    public function a_volleyball_match_goes_up_until_the_point_limit_is_reached_test()
    {
        $this->preparePayloadWithOwnTeamWinningTheSetAfterPointLimit();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'][0] == 27);
        $this->assertTrue($result['score']['rival'][0] == 25);
        $this->assertTrue($result['score']['own'][1] == 1);
        $this->assertTrue($result['score']['rival'][1] == 0);
    }

    /**
     * @test
     * 
     * Test a volleyball match goes up until
     * there is a winner, no matter is there
     * are more actitivites registered
     */
    public function a_volleyball_match_goes_up_until_there_is_a_winner_test()
    {
        $this->preparePayloadWithOwnTeamWinningTheMatchAfterTheSetLimitIsReached();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'][0] == 25);
        $this->assertTrue($result['score']['own'][1] == 25);
        $this->assertTrue($result['score']['own'][2] == 25);
        $this->assertTrue($result['score']['own'][3] == 0);
        $this->assertTrue($result['score']['own'][4] == 0);
    }

    /**
     * @test
     * 
     * Test a volleyball match goes up until
     * there is a winner, no matter is there
     * are more actitivites registered
     */
    public function a_volleyball_match_ends_at_15_points_on_the_last_set()
    {
        $this->preparePayloadWithOwnTeamWinningTheMatchOnTheLastSetWith15Points();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'][0] == 25);
        $this->assertTrue($result['score']['own'][2] == 25);
        $this->assertTrue($result['score']['own'][4] == 15);
        $this->assertTrue($result['score']['winner'] == VolleyballScoringSystem::OWN_MATCH_WINNER);
    }
}
