<?php

namespace Modules\Scouting\Cache;

use App\Cache\BaseCache;
use Modules\Scouting\Repositories\Interfaces\ActionRepositoryInterface;

class ActionCache extends BaseCache 
{
    /**
     * @var object
     */
    protected $actionRepository;

    public function __construct(ActionRepositoryInterface $actionRepository)
    {
        parent::__construct('action');

        $this->actionRepository = $actionRepository;
    }


    public function findAllActionsAndTotalsBySport($sport_id)
    {
        $key = $this->key . app()->getLocale() . '_' . $sport_id;

        return $this->cache::remember($key, self::TTL, function() use($sport_id){
            return $this->actionRepository->findBy([
                'sport_id' => $sport_id
            ])->toArray();
        });
    }

}