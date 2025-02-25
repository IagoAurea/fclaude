<?php

namespace Modules\Sport\Cache;

use App\Cache\BaseCache;
use Modules\Sport\Repositories\Interfaces\SportPositionRepositoryInterface;

class SportPositionCache extends BaseCache 
{
    /**
     * @var object
     */
    protected $sportPositionRepository;

    /**
     * Create a new cache instance
     */
    public function __construct(SportPositionRepositoryInterface $sportPositionRepository)
    {
        parent::__construct('sport_position');

        $this->sportPositionRepository = $sportPositionRepository;
    }

    /**
     * Find all positions translated
     */
    public function findAllTranslated($sportId)
    {
        $locale = app()->getLocale();
        
        return $this->cache::remember($this->key . $locale, self::TTL, function() use ($sportId) {
            return $this->sportPositionRepository->findAllTranslated($sportId);
        });
    }
}