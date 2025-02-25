<?php

namespace Modules\Scouting\Tests\Unit\Services;

use Modules\Scouting\Processors\SideEffects\IndoorSoccer\DoublePenalties;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\CornerKicks;
use Modules\Scouting\Tests\Fixtures\IndoorSoccerMatchFixturesTrait;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Penalties;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\ThrowsIn;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Passes;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Duels;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Shots;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Scouting\Processors\ResultsProcessor;
use Tests\ModuleTestCase;

class IndoorSoccerResultsProcessorTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use IndoorSoccerMatchFixturesTrait;

    /**
     * @test
     * 
     * Test the results of a indoor soccer match that doesnt have
     * any goal activities recorded will return 0 to 0
     * as the score result
     */
    public function a_indoor_soccer_match_that_doesnt_record_goal_activities_returns_0_0_as_score_result()
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
     * Test the results of a indoor soccer match that has 2 goals
     * activities recorded will return 1 to 1
     * as the score result
     */
    public function a_indoor_soccer_match_with_a_goal_recorded_for_each_team_returns_1_1_as_score_result()
    {
        $this->preparePayloadWith1GoalForEachTeam();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['score']['own'] == 1);
        $this->assertTrue($result['score']['rival'] == 1);
    }

    /**
     * @test
     * 
     * Test the results of a indoor soccer match that has 2 corner
     * kicks activities recorded, 1 for the corner kicks won and 1
     * for the corner kicks lost will return 2 as the total
     * of corner kicks
     */
    public function a_indoor_soccer_match_with_a_corner_kick_recorded_for_each_team_returns_2_as_the_total()
    {
        $this->preparePayloadWith1CornerKickWonAnd1Lost();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['statistics'][CornerKicks::STATISTIC_NAME] == 2);
    }

    /**
     * @test
     * 
     * Test the results of a indoor soccer match that has 2 corner
     * kicks activities recorded, 1 for the corner kicks won and 1
     * for the corner kicks lost will return 2 as the total
     * of corner kicks
     */
    public function a_indoor_soccer_match_with_a_throw_in_recorded_for_each_team_returns_2_as_the_total()
    {
        $this->preparePayloadWith1ThrowInWonAnd1Lost();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['statistics'][ThrowsIn::STATISTIC_NAME] == 2);
    }

    /**
     * @test
     * 
     * Test the results of a indoor soccer match that has 2 duel
     * activities recorded, 1 for the duel won and 1
     * for the duel lost will return 2 as the total
     * of duels
     */
    public function a_indoor_soccer_match_with_a_duel_recorded_for_each_team_returns_2_as_the_total()
    {
        $this->preparePayloadWith1DuelWonAnd1Lost();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['statistics'][Duels::STATISTIC_NAME] == 2);
    }

    /**
     * @test
     * 
     * Test the results of a indoor soccer match that has 2 passes
     * activities recorded, 1 for the successful pass and 1
     * for the missed pass will return 2 as the total
     * of passes
     */
    public function a_indoor_soccer_match_with_a_pass_recorded_as_successful_and_one_as_missed_returns_2_as_the_total()
    {
        $this->preparePayloadWith1PassSuccessfulAnd1Missed();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['statistics'][Passes::STATISTIC_NAME] == 2);
    }

    /**
     * @test
     * 
     * Test the results of a indoor soccer match that has 2 shots
     * activities recorded, 1 for the on target shot and 1
     * for the off target shot will return 2 as the total
     * of shots
     */
    public function a_indoor_soccer_match_with_a_shot_recorded_on_target_and_one_off_target_returns_2_as_the_total()
    {
        $this->preparePayloadWith1ShotOnTargetAnd1OffTarget();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['statistics'][Shots::STATISTIC_NAME] == 2);
    }

    /**
     * @test
     * 
     * Test the results of a indoor soccer match that has 2 penalties
     * activities recorded, 1 scored penalty and 1
     * missed penalty will return 2 as the total
     * of penalties
     */
    public function a_indoor_soccer_match_with_a_penalty_scored_recorded_and_one_missed_returns_2_as_the_total_and_counts_the_score()
    {
        $this->preparePayloadWith1PenaltyScoredAnd1Missed();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['statistics'][Penalties::STATISTIC_NAME] == 2);
        $this->assertTrue($result['score']['own'] == 1);
    }

    /**
     * @test
     * 
     * Test the results of a indoor soccer match that has 2 double penalties
     * activities recorded, 1 scored double penalty and 1
     * missed double penalty will return 2 as the total
     * of double penalties
     */
    public function a_indoor_soccer_match_with_a_double_penalty_scored_recorded_and_one_missed_returns_2_as_the_total_and_counts_the_score()
    {
        $this->preparePayloadWith1DoublePenaltyScoredAnd1Missed();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['statistics'][DoublePenalties::STATISTIC_NAME] == 2);
        $this->assertTrue($result['score']['own'] == 1);
    }
}
