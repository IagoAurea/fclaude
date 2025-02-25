<?php

namespace Modules\Scouting\Tests\Unit\Services;

use Modules\Scouting\Tests\Fixtures\BasketballMatchFixturesTrait;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Scouting\Processors\ResultsProcessor;
use Tests\ModuleTestCase;

class BasketballResultsProcessorTest extends ModuleTestCase
{
    use DatabaseTransactions;
    use BasketballMatchFixturesTrait;

    /**
     * @test
     * 
     * Test the results of a basket match that doesnt have
     * any goal activities recorded will return 0 to 0
     * as the score result
     */
    public function a_basketball_match_that_doesnt_record_points_activities_returns_0_0_as_score_result()
    {
        $this->preparePayloadWithNoPoints();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload[0]->scouting->competition_match_id);

        $this->assertTrue($result['score']['own'] == 0);
        $this->assertTrue($result['score']['rival'] == 0);
    }

    /**
     * @test
     * 
     * Test the results of a basket match that has 10 three points
     * activities recorded will return 30 to 0
     * as the score result
     */
    public function a_basketball_match_with_10_activities_of_three_points_returns_30_0_as_score_result()
    {
        $this->preparePayloadWith30PointsByThreePointsActions();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'] == 30);
        $this->assertTrue($result['score']['rival'] == 0);
    }

    /**
     * @test
     * 
     * Test the results of a basket match that has 10 two points
     * activities recorded will return 20 to 0
     * as the score result
     */
    public function a_basketball_match_with_10_activities_of_two_points_returns_20_0_as_score_result()
    {
        $this->preparePayloadWith30PointsByTwoPointsActions();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'] == 20);
        $this->assertTrue($result['score']['rival'] == 0);
    }

    /**
     * @test
     * 
     * Test the results of a basket match that has 10 two points
     * activities recorded will return 20 to 0
     * as the score result
     */
    public function a_basketball_match_with_10_activities_of_one_points_returns_10_0_as_score_result()
    {
        $this->preparePayloadWith30PointsByOnePointsActions();

        $processor = $this->app->make(ResultsProcessor::class);
        $result = $processor->match($this->payload->competition_match_id);

        $this->assertTrue($result['score']['own'] == 10);
        $this->assertTrue($result['score']['rival'] == 0);
    }
}
