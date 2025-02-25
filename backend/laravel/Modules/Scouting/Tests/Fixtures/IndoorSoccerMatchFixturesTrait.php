<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Scouting\Processors\SideEffects\IndoorSoccer\DoublePenalties;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\CornerKicks;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Penalties;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\ThrowsIn;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Goals;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Duels;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Passes;
use Modules\Scouting\Processors\SideEffects\IndoorSoccer\Shots;
use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\Competition;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\Action;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\Team;

trait IndoorSoccerMatchFixturesTrait
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
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();
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
     * @return void
     */
    private function preparePayloadWith1GoalForEachTeam()
    {
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();

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

    /**
     * Prepare the payload to be an array
     * of 2 scouting activities, one
     * corner kick won and one corner
     * kick lost
     *
     * @return void
     */
    private function preparePayloadWith1CornerKickWonAnd1Lost()
    {
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();

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

        $corner_kick_won_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => CornerKicks::CORNER_KICK_WON_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $corner_kick_lost_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => CornerKicks::CORNER_KICK_LOST_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $corner_kick_won_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $corner_kick_lost_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }

    /**
     * Prepare the payload to be an array
     * of 2 scouting activities, one
     * throw in won and one corner
     * kick lost
     *
     * @return void
     */
    private function preparePayloadWith1ThrowInWonAnd1Lost()
    {
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();

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

        $throw_in_won_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => ThrowsIn::THROW_IN_WON_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $throw_in_lost_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => ThrowsIn::THROW_IN_LOST_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $throw_in_won_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $throw_in_lost_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }

    /**
     * Prepare the payload to be an array
     * of 2 scouting activities, one
     * throw in won and one corner
     * kick lost
     *
     * @return void
     */
    private function preparePayloadWith1DuelWonAnd1Lost()
    {
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();

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

        $duel_won_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Duels::DUEL_WON_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $duel_lost_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Duels::DUEL_LOST_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $duel_won_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $duel_lost_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }

    /**
     * Prepare the payload to be an array
     * of 2 scouting activities, one
     * successful pass and one
     * missing pass
     *
     * @return void
     */
    private function preparePayloadWith1PassSuccessfulAnd1Missed()
    {
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();

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

        $successful_pass_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Passes::PASS_SUCCESSFUL_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $missed_pass_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Passes::PASS_MISSED_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $successful_pass_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $missed_pass_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }

    /**
     * Prepare the payload to be an array
     * of 2 scouting activities, one
     * on target shot and one
     * off target shot
     *
     * @return void
     */
    private function preparePayloadWith1ShotOnTargetAnd1OffTarget()
    {
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();

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

        $shot_on_target_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Shots::SHOT_ON_TARGET_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $shot_off_target_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Shots::SHOT_OFF_TARGET_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $shot_on_target_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $shot_off_target_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }

    /**
     * Prepare the payload to be an array
     * of 2 scouting activities, one
     * scored penalty and one
     * missed penalty
     *
     * @return void
     */
    private function preparePayloadWith1PenaltyScoredAnd1Missed()
    {
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();

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

        $penalty_scored_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Penalties::PENALTY_SCORED_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $penalty_missed_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Penalties::PENALTY_MISSED_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $penalty_scored_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $penalty_missed_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }

    /**
     * Prepare the payload to be an array
     * of 2 scouting activities, one
     * scored double penalty and one
     * missed double penalty
     *
     * @return void
     */
    private function preparePayloadWith1DoublePenaltyScoredAnd1Missed()
    {
        $sport = Sport::where('code', Sport::INDOOR_SOCCER)->first();

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

        $double_penalty_scored_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => DoublePenalties::DOUBLE_PENALTY_SCORED_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $double_penalty_missed_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => DoublePenalties::DOUBLE_PENALTY_MISSED_SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $double_penalty_scored_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $double_penalty_missed_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }
}
