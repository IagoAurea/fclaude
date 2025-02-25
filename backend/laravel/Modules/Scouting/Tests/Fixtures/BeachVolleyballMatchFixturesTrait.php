<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Competition\Entities\Competition;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Scouting\Entities\Action;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Scouting\Processors\SideEffects\Volleyball\Points;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\Team;

trait BeachVolleyballMatchFixturesTrait
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
     * Prepare the payload to be a scouting,
     * with many activities registered,
     * in order to recreate a match
     * that has a set that goes
     * beyond the regular set
     * number until the
     * point limit is
     * reached
     *
     * @param string $status
     * @return void
     */
    private function preparePayloadWithOwnTeamWinningTheSetAfterPointLimit()
    {
        $sport = Sport::where('code', Sport::BEACH_VOLLEYBALL)->first();
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

        $point_won_action = Action::factory()
            ->create([
                'name' => 'Point won',
                'slug' => 'point_won',
                'side_effect' => Points::POINT_WON_SIDE_EFFECT,
                'sport_id' => $sport->id,
            ]);

        $point_lost_action = Action::factory()
            ->create([
                'name' => 'Point lost',
                'slug' => 'point_lost',
                'side_effect' => Points::POINT_LOST_SIDE_EFFECT,
                'sport_id' => $sport->id,
            ]);

        ScoutingActivity::factory()
            ->count(20)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->count(20)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');
            
        ScoutingActivity::factory()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');
            
        ScoutingActivity::factory()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');
            
            ScoutingActivity::factory()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');
            
            ScoutingActivity::factory()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');
            
            ScoutingActivity::factory()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');


        $this->payload = $scouting;
    }

    /**
     * Prepare the payload to be a scouting,
     * with many activities registered,
     * in order to recreate a match
     * that stops registering
     * the score until the
     * set limit is
     * reached
     *
     * @param string $status
     * @return void
     */
    private function preparePayloadWithOwnTeamWinningTheMatchAfterTheSetLimitIsReached()
    {
        $sport = Sport::where('code', Sport::BEACH_VOLLEYBALL)->first();
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

        $point_won_action = Action::factory()
            ->create([
                'name' => 'Point won',
                'slug' => 'point_won',
                'side_effect' => Points::POINT_WON_SIDE_EFFECT,
                'sport_id' => $sport->id,
            ]);

        ScoutingActivity::factory()
            ->count(43)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        $this->payload = $scouting;
    }

    /**
     * Prepare the payload to be a scouting,
     * with many activities registered,
     * in order to recreate a match
     * that stops registering
     * the score until the
     * set limit is
     * reached
     *
     * @param string $status
     * @return void
     */
    private function preparePayloadWithOwnTeamWinningTheMatchOnTheLastSetWith15Points()
    {
        $sport = Sport::where('code', Sport::BEACH_VOLLEYBALL)->first();
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

        $point_won_action = Action::factory()
            ->create([
                'name' => 'Point won',
                'slug' => 'point_won',
                'side_effect' => Points::POINT_WON_SIDE_EFFECT,
                'sport_id' => $sport->id,
            ]);

        $point_lost_action = Action::factory()
            ->create([
                'name' => 'Point lost',
                'slug' => 'point_lost',
                'side_effect' => Points::POINT_LOST_SIDE_EFFECT,
                'sport_id' => $sport->id,
            ]);

        ScoutingActivity::factory()
            ->count(21)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->count(21)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');


        ScoutingActivity::factory()
            ->count(16)
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        $this->payload = $scouting;
    }
}
