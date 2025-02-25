<?php

namespace Modules\Scouting\Tests\Fixtures;

use Modules\Scouting\Processors\SideEffects\Badminton\PointsByWinnerShots;
use Modules\Scouting\Processors\SideEffects\Badminton\Shots;
use Modules\Competition\Entities\CompetitionRivalTeam;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\Scouting\Entities\ScoutingActivity;
use Modules\Competition\Entities\Competition;
use Modules\Scouting\Entities\Scouting;
use Modules\Scouting\Entities\Action;
use Modules\Sport\Entities\Sport;
use Modules\Team\Entities\Team;

trait BadmintonMatchFixturesTrait
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
        $sport = Sport::where('code', Sport::BADMINTON)->first();
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
                'side_effect' => Shots::SHOT_SIDE_EFFECT,
                'sport_id' => $sport->id,
            ]);

        $point_lost_action = Action::factory()
            ->create([
                'name' => 'Point lost',
                'slug' => 'point_lost',
                'side_effect' => Shots::SHOT_SIDE_EFFECT,
                'rival_team_action' => true,
                'sport_id' => $sport->id,
            ]);

        ScoutingActivity::factory()
            ->count(20)
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id,
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->count(20)
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');
            
        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');
            
        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');
            
            ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');
            
            ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');
            
            ScoutingActivity::factory()
            ->winner()
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
        $sport = Sport::where('code', Sport::BADMINTON)->first();
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
                'side_effect' => Shots::SHOT_SIDE_EFFECT,
                'sport_id' => $sport->id,
            ]);

        ScoutingActivity::factory()
            ->count(43)
            ->winner()
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
    private function preparePayloadWithOwnTeamWinningTheMatchOnTheLastSetWith30Points()
    {
        $sport = Sport::where('code', Sport::BADMINTON)->first();
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
                'side_effect' => Shots::SHOT_SIDE_EFFECT,
                'sport_id' => $sport->id,
            ]);

        $point_lost_action = Action::factory()
            ->create([
                'name' => 'Point lost',
                'slug' => 'point_lost',
                'side_effect' => Shots::SHOT_SIDE_EFFECT,
                'rival_team_action' => true,
                'sport_id' => $sport->id,
            ]);

        ScoutingActivity::factory()
            ->count(21)
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->count(21)
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->count(20)
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->count(20)
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_won_action->id
            ])
            ->load('action');

        ScoutingActivity::factory()
            ->winner()
            ->create([
                'scouting_id' => $scouting->id,
                'action_id' => $point_lost_action->id
            ])
            ->load('action');

        $this->payload = $scouting;
    }
}
