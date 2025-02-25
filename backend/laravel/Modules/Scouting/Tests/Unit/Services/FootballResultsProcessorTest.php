<?php

namespace Modules\Scouting\Tests\Unit\Services;

use Modules\Scouting\Tests\Fixtures\FootballMatchFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Scouting\Processors\ResultsProcessor;
use Tests\ModuleTestCase;

class FootballResultsProcessorTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use FootballMatchFixturesTrait;

    /**
     * @test
     * 
     * Test the results of a football match that doesnt have
     * any goal activities recorded will return 0 to 0
     * as the score result
     */
    public function a_footbal_match_that_doesnt_record_goal_activities_returns_0_0_as_score_result()
    {
        $this->preparePayloadWithNoGoals();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['score']['own'] == 0);
        $this->assertTrue($result['score']['rival'] == 0);
    }

    /**
     * @test
     * 
     * Test the results of a football match that has 2 goals
     * activities recorded will return 1 to 1
     * as the score result
     */
    public function a_footbal_match_with_a_goal_recorded_for_each_team_returns_1_1_as_score_result()
    {
        $this->preparePayloadWith1GoalForEachTeam();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['score']['own'] == 1);
        $this->assertTrue($result['score']['rival'] == 1);
    }
}
