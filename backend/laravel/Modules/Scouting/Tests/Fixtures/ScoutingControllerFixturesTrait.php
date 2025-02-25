<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\Competition;
use Modules\Scouting\Entities\Scouting;

trait ScoutingControllerFixturesTrait
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
     * Prepare the payload to be an array
     * of 2 competition matches
     *
     * @return void
     */
    private function preparePayload()
    {
        $competition = Competition::factory()->create();
        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);
        $rival_team2 = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);

        $competition_match = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team->id
        ]);

        $competition_match2 = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team2->id
        ]);


        $this->payload[0] = $competition_match;
        $this->payload[1] = $competition_match2;
    }

    /**
     * Prepare the payload to be a scouting
     *
     * @return void
     */
    private function preparePayloadWithScouting($status, $in_game_time = null)
    {
        $competition = Competition::factory()->create();
        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);

        $competition_match = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team->id
        ]);

        $payload = [
            'competition_match_id' => $competition_match->id,
            'status' => $status
        ];

        if ($in_game_time != NULL) {
            $payload['in_game_time'] = $in_game_time;
        }

        $scouting = Scouting::factory()->create($payload);

        $this->payload = $scouting;
    }

    /**
     * Prepare the payload to be an array
     * of 4 competition matches
     *
     * @return void
     */
    private function preparePayloadMultipleCompetitions()
    {
        $competition = Competition::factory()->create();
        $competition2 = Competition::factory()->create();

        $rival_team = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);
        $rival_team2 = CompetitionRivalTeam::factory()->create(['competition_id' => $competition->id]);
        $rival_team3 = CompetitionRivalTeam::factory()->create(['competition_id' => $competition2->id]);
        $rival_team4 = CompetitionRivalTeam::factory()->create(['competition_id' => $competition2->id]);

        $competition_match = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team->id
        ]);

        $competition_match2 = CompetitionMatch::factory()->create([
            'competition_id' => $competition->id,
            'competition_rival_team_id' => $rival_team2->id
        ]);

        $competition_match3 = CompetitionMatch::factory()->create([
            'competition_id' => $competition2->id,
            'competition_rival_team_id' => $rival_team3->id
        ]);

        $competition_match4 = CompetitionMatch::factory()->create([
            'competition_id' => $competition2->id,
            'competition_rival_team_id' => $rival_team4->id
        ]);

        $this->payload[0] = $competition_match;
        $this->payload[1] = $competition_match2;
        $this->payload[2] = $competition_match3;
        $this->payload[3] = $competition_match4;
    }
}
