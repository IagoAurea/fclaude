<?php

namespace Modules\Club\Cache;

use App\Cache\BaseCache;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

class ClubCache extends BaseCache
{
    /**
     * @var object
     */
    protected $clubRepository;

    public function __construct(ClubRepositoryInterface $clubRepository)
    {
        parent::__construct('club');

        $this->clubRepository = $clubRepository;
    }


    public function findUserClubs($userId, $type, $typeId, $clubsIds)
    {
        $key = sprintf('%s-%s-user-%s', $this->key, $type, $userId);

        return $this->cache::remember($key, self::TTL, function() use($userId, $typeId, $clubsIds){
            return $this->clubRepository->findUserClubs($userId, $typeId, $clubsIds);
        });
    }

    public function deleteUserClubs($userId, $type)
    {
        $key = sprintf('%s-%s-user-%s', $this->key, $type, $userId);

        return $this->cache::forget($key);
    }

}