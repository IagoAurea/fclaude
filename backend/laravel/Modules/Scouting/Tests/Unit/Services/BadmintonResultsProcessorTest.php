<?php

namespace Modules\Scouting\Tests\Unit\Services;

use Modules\Scouting\Tests\Fixtures\BadmintonMatchFixturesTrait;
use Modules\Scouting\Processors\Score\BadmintonScoringSystem;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Scouting\Processors\ResultsProcessor;
use Tests\ModuleTestCase;

class BadmintonResultsProcessorTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use BadmintonMatchFixturesTrait;

    /**
     * @test
     * 
     * Test a set of a badminton match goes
     * up until the point limit is reached
     */
    public function a_badminton_match_goes_up_until_the_point_limit_is_reached_test()
    {
        $this->preparePayloadWithOwnTeamWinningTheSetAfterPointLimit();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'][0] == 23);
        $this->assertTrue($result['score']['rival'][0] == 21);
        $this->assertTrue($result['score']['own'][1] == 1);
        $this->assertTrue($result['score']['rival'][1] == 0);
    }

    /**
     * @test
     * 
     * Test a badminton match goes up until
     * there is a winner, no matter is there
     * are more actitivites registered
     */
    public function a_badminton_match_goes_up_until_there_is_a_winner_test()
    {
        $this->preparePayloadWithOwnTeamWinningTheMatchAfterTheSetLimitIsReached();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'][0] == 21);
        $this->assertTrue($result['score']['own'][1] == 21);
        $this->assertTrue($result['score']['own'][2] == 0);
        $this->assertTrue($result['score']['winner'] == BadmintonScoringSystem::OWN_MATCH_WINNER);
    }

    /**
     * @test
     * 
     * Test a badminton match ties break when
     * a team reach the 30 point limit
     */
    public function a_badminton_match_ends_at_30_when_tie()
    {
        $this->preparePayloadWithOwnTeamWinningTheMatchOnTheLastSetWith30Points();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'][0] == 21);
        $this->assertTrue($result['score']['own'][2] == 30);
        $this->assertTrue($result['score']['winner'] == BadmintonScoringSystem::OWN_MATCH_WINNER);
    }
}
