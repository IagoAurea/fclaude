<?php

namespace Modules\Scouting\Services\Interfaces;

interface ScoutingResultServiceInterface
{
    /**
     * Convert statistics to object
     * 
     * @param array $statistics
     * @param int $competition_match_id
     * @return object;
     */
    public function convertStatistics($statistics, $competition_match_id, $allStatistics, $onlyOwn);
}
