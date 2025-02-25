<?php

namespace Modules\Psychology\Services;

use Modules\Club\Entities\ClubType;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Psychology\Repositories\Interfaces\PsychologyReportRepositoryInterface;

class PsychologyService
{
    /**
     * Repository
     * @var $psychologyReportRepository
     */
    protected $psychologyReportRepository;

    /**
     * Player repository
     * @var $playerRepository
     */
    protected $playerRepository;

     /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * PsychologyService constructor.
     * @param PlayerRepositoryInterface $playerRepository
     */
    public function __construct(
        PsychologyReportRepositoryInterface $psychologyReportRepository,
        PlayerRepositoryInterface $playerRepository,
        ClubRepositoryInterface $clubRepository
    )
    {
        $this->psychologyReportRepository = $psychologyReportRepository;
        $this->playerRepository = $playerRepository;
        $this->clubRepository = $clubRepository;
    }

    /**
     * Retrieve all psychology reports create by user
     */
    public function allPsychologyReportsByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, ClubType::CLUB_TYPE_SPORT, [], ['teams.players']);

        $clubs->makeHidden(['users']);

        $total_psychology_reports = $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                return $team->players->map(function ($player) {
                    $player->tests = $this->psychologyReportRepository->findBy([
                      'player_id' => $player->id
                    ]);

                    return $player->tests->count();
                })->sum();
            })->sum();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_psychology_reports' => $total_psychology_reports ?? 0
        ];
    }

    /**
     * Get players with psychology data
     * @param Request $filters
     * @param integer $team_id
     * @return Array
     */
    public function getPlayersWithPsychologyByTeam($filters, $team_id)
    {
        $players = $this->playerRepository->getPlayersWithPsychologyDataByTeam($filters, $team_id);

        foreach ($players as $player) {
            $player->count_reports = $player->psychologyReports->count();
            
            $player->last_date_report = $player->psychologyReports->count() > 0 ?
                $player->psychologyReports[0]->date : null;
            $player->last_id_report = $player->psychologyReports->count() > 0 ?
                $player->psychologyReports[0]->id : null;
        }

        return $players;
    }

}