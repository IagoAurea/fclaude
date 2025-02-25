<?php

namespace Modules\Competition\Repositories\Interfaces;

interface CompetitionMatchRepositoryInterface
{
    public function findAllNextMatchesByTeamId($team_id);

    public function findLastMatchByCompetition($competition_id);

    public function findAllByCompetition($competition_id);

    public function findAllRecentMatchesByTeamId($team_id);

    public function findAllCompetitionMatches($team, $groupType = NULL);

    public function findAllClubTeamsMatches($club, $groupType = NULL);

    public function findMatchRivalTeamByDateUnderCurrent($rival_team);

    public function findSportByCompetitionMatch($competition_match_id);
}
