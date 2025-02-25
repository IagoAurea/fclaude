<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Competition\Entities\Competition;
use Modules\Scouting\Entities\Scouting;

trait ScoutingActivityControllerFixturesTrait
{
    /**
     * The payload property will be used
     * to store the testing data for
     * every test case running
     *
     * @var mixed
     */
    private $payload = [];

    /**
     * Prepare the payload to be a scouting
     * with variable status
     *
     * @param string $status
     * @return void
     */
    private function preparePayload($status = Scouting::STATUS_STARTED)
    {
        $competition = Competition::factory()->create();
        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);

        $competition_match = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team->id
        ]);

        $scouting = Scouting::factory()->create([
            'competition_match_id' => $competition_match->id,
            'status' => $status,
        ]);

        $this->payload = $scouting;
    }

    /**
     * Prepare the payload to be an array
     * of 2 scouting activities
     *
     * @param string $status
     * @param bool $undoStatus
     * @return void
     */
    private function preparePayloadWithActivities($status = Scouting::STATUS_STARTED, $undoStatus = true)
    {
        $competition = Competition::factory()->create();
        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);
        
        $competition_match = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team->id
        ]);

        $scouting = Scouting::factory()->create([
            'competition_match_id' => $competition_match->id,
            'status' => $status,
        ]);

        $activity = ScoutingActivity::factory()->create(['scouting_id' => $scouting->id])->load('action');
        $activity2 = ScoutingActivity::factory()->create([
            'scouting_id' => $scouting->id,
            'status' => $undoStatus
        ])->load('action');

        $this->payload = [$activity, $activity2];
    }
}
