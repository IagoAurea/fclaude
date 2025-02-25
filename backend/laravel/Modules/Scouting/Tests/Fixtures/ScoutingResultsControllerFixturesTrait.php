<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\Competition;
use Modules\Player\Entities\Player;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\Team;

trait ScoutingResultsControllerFixturesTrait
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
     * @return void
     */
    private function preparePayload()
    {
        $code = 'NOT_EXISTING';
        $sport = Sport::create(['code' => $code, 'model_url' => 'index.html']);
        $team = Team::factory(['sport_id' => $sport->id])->create();
        $competition = Competition::factory(['team_id' => $team->id])->create();
        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);

        $competition_match = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team->id
        ]);

        $scouting = Scouting::factory()->create([
            'competition_match_id' => $competition_match->id,
            'status' => Scouting::STATUS_STARTED,
        ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id])
            ->load('action');

        $this->payload = [$activity, $code];
    }

    /**
     * Prepare the payload to be a scouting
     * with variable status
     *
     * @return void
     */
    private function preparePayloadWithPlayerActivities()
    {
        $sport = Sport::where('code', Sport::FOOTBALL)->first();
        $team = Team::factory(['sport_id' => $sport->id])->create();
        $player_id = Player::factory()->create(['team_id' => $team->id]);
        $competition = Competition::factory(['team_id' => $team->id])->create();
        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);
        $rival_team_2 = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);

        $competition_match = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team->id
        ]);

        $competition_match_2 = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team_2->id
        ]);

        $scouting = Scouting::factory()->create([
            'competition_match_id' => $competition_match->id,
            'status' => Scouting::STATUS_STARTED,
        ]);

        $scouting_2 = Scouting::factory()->create([
            'competition_match_id' => $competition_match_2->id,
            'status' => Scouting::STATUS_STARTED
        ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'player_id' => $player_id])
            ->load('action');

        $activity_2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting_2->id, 'player_id' => $player_id])
            ->load('action');

        $this->payload = [$activity, $activity_2, $player_id];
    }
}
