<?php

namespace Modules\Competition\Cache;

use App\Cache\BaseCache;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;

class CompetitionMatchCache extends BaseCache 
{
    /**
     * @var object
     */
    protected $competitionMatchRepository;

    public function __construct(CompetitionMatchRepositoryInterface $competitionMatchRepository)
    {
        parent::__construct('competition_match');

        $this->competitionMatchRepository = $competitionMatchRepository;
    }


    public function sportIdByCompetitionMatch($competition_match_id)
    {
        $key = $this->key . '_' . $competition_match_id;

        return $this->cache::remember($key, self::TTL, function() use($competition_match_id){
            return $this->competitionMatchRepository
                ->findSportByCompetitionMatch($competition_match_id);
        });
    }

}