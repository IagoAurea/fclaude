<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Scouting\Entities\Action;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\SideEffects\Handball\Goals;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\Team;

trait HandballMatchFixturesTrait
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
    private function preparePayloadWithNoGoals()
    {
        $sport = Sport::where('code', Sport::HANDBALL)->first();
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
     * Prepare the payload to be an array
     * of 2 scouting activities, one
     * goal for the own team
     * and one goal for
     * the rival team
     *
     * @param string $status
     * @return void
     */
    private function preparePayloadWith1GoalForEachTeam()
    {
        $sport = Sport::where('code', Sport::HANDBALL)->first();

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

        $own_goal_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Goals::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $rival_team_goal_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'rival_team_action' => true,
                'side_effect' => Goals::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_goal_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $rival_team_goal_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }
}
