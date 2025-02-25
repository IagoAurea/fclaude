<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Scouting\Entities\Action;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\SideEffects\Basketball\Points;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\Team;

trait BasketballMatchFixturesTrait
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
     * of 2 scouting activities
     *
     * @param string $status
     * @return void
     */
    private function preparePayloadWithNoPoints()
    {
        $sport = Sport::where('code', Sport::BASKETBALL)->first();
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

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }

    /**
     * Prepare the payload to be a scouting
     * with 10 activities of three points
     * each one
     *
     * @return void
     */
    private function preparePayloadWith30PointsByThreePointsActions()
    {
        $sport = Sport::where('code', Sport::BASKETBALL)->first();
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

        $three_points_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Points::THREE_POINT_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->count(10)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $three_points_action->id,
                ])
            ->load('action');

        $this->payload = $scouting;
    }

    /**
     * Prepare the payload to be a scouting
     * with 10 activities of two points
     * each one
     *
     * @return void
     */
    private function preparePayloadWith30PointsByTwoPointsActions()
    {
        $sport = Sport::where('code', Sport::BASKETBALL)->first();
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

        $two_points_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Points::TWO_POINT_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->count(10)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $two_points_action->id,
                ])
            ->load('action');

        $this->payload = $scouting;
    }

    /**
     * Prepare the payload to be a scouting
     * with 10 activities of one points
     * each one
     *
     * @return void
     */
    private function preparePayloadWith30PointsByOnePointsActions()
    {
        $sport = Sport::where('code', Sport::BASKETBALL)->first();
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

        $one_points_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Points::ONE_POINT_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->count(10)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $one_points_action->id,
                ])
            ->load('action');

        $this->payload = $scouting;
    }
}