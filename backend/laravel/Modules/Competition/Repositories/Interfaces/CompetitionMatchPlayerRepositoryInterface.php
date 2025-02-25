<?php

namespace Modules\Competition\Repositories\Interfaces;

interface CompetitionMatchPlayerRepositoryInterface
{
    public function rpeLastMatchPlayer($player_id);

    public function playedGamesByCompetition($competition_id, $player_id);

    public function countMatchesPlayer($player_id);
}
