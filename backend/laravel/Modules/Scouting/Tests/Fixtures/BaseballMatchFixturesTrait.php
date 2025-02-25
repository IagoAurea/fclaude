<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Scouting\Entities\Action;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\SideEffects\Baseball\Runs;
use Modules\Scouting\Processors\SideEffects\Baseball\Strikes;
use Modules\Scouting\Processors\SideEffects\Baseball\Balls;
use Modules\Scouting\Processors\SideEffects\Baseball\Errors;
use Modules\Scouting\Processors\SideEffects\Baseball\Outs;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\Team;

trait BaseballMatchFixturesTrait
{
    /**
     * * The payload property will be used
     * * to store the testing data for
     * * every test case running
     *
     * @var mixed
     */
    private $payload = [];

    /**
     * * Prepare the payload to be an array
     * * of 2 scouting activities
     *
     * @param string $status
     * @return void
     */
    private function preparePayloadWithNoRuns()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();
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
     * * Prepare the payload to be an array
     * * of 2 scouting activities, one
     * * run for the own team
     * * and one run for
     * * the rival team
     *
     * @return void
     */
    private function preparePayloadWith1RunsForEachTeam()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();

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

        $own_run_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Runs::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $rival_team_run_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'rival_team_action' => true,
                'side_effect' => Runs::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);

        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_run_action->id])
            ->load('action');

        $activity2 = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $rival_team_run_action->id])
            ->load('action');

        $this->payload = [$activity, $activity2];
    }

    /**
     * * Prepare the payload to be an array
     * * of a scouting activity, a strike
     *
     * @return void
     */
    private function preparePayloadWith1Strike()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();

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

        $own_run_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Strikes::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);


        $activity = ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_run_action->id])
            ->load('action');

        $this->payload = $activity;
    }

    /**
     * * Prepare the payload to be a
     * * strike scouting activity
     *
     * @return void
     */
    private function preparePayloadWith3Strikes()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();

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

        $own_run_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Strikes::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);


        ScoutingActivity::factory()
            ->count(3)
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_run_action->id])
            ->load('action');

        $this->payload = $scouting;
    }

    /**
     * * Prepare the payload to be a
     * * ball scouting activity
     *
     * @return void
     */
    private function preparePayloadWith1Ball()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();

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

        $own_ball_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Balls::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);


        ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_ball_action->id])
            ->load('action');

        $this->payload = $scouting;
    }

    /**
     * * Prepare the payload to be an array of
     * * ball scouting activities
     *
     * @return void
     */
    private function preparePayloadWith4Ball()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();

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

        $own_ball_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Balls::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);


        ScoutingActivity::factory()
            ->count(4)
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_ball_action->id])
            ->load('action');

        $this->payload = $scouting;
    }

    /**
     * * Prepare the payload to be 1
     * * error scouting activities
     *
     * @return void
     */
    private function preparePayloadWith1Error()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();

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

        $own_error_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Errors::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);


        ScoutingActivity::factory()
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_error_action->id])
            ->load('action');

        $this->payload = $scouting;
    }

    /**
     * * Prepare the payload to be 1
     * * error scouting activities
     *
     * @return void
     */
    private function preparePayloadWith4Errors()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();

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

        $own_error_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Errors::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);


        ScoutingActivity::factory()
            ->count(4)
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_error_action->id])
            ->load('action');

        $this->payload = $scouting;
    }

    /**
     * * Prepare the payload to be 3
     * * outs scouting activities
     *
     * @return void
     */
    private function preparePayloadWith3Outs()
    {
        $sport = Sport::where('code', Sport::BASEBALL)->first();

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

        $own_out_action = Action::factory()
            ->create([
                'name' => $this->faker->name(),
                'side_effect' => Outs::SIDE_EFFECT,
                'sport_id' => $sport->id
            ]);


        ScoutingActivity::factory()
            ->count(3)
            ->create(['scouting_id' => $scouting->id, 'action_id' => $own_out_action->id])
            ->load('action');

        $this->payload = $scouting;
    }
}
