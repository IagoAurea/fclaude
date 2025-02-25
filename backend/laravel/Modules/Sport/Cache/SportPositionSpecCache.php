<?php

namespace Modules\Sport\Cache;

use App\Cache\BaseCache;
use Modules\Sport\Repositories\Interfaces\SportPositionSpecRepositoryInterface;

class SportPositionSpecCache extends BaseCache 
{
    /**
     * @var object
     */
    protected $sportPositionSpecRepository;

    /**
     * Create a new cache instance
     */
    public function __construct(SportPositionSpecRepositoryInterface $sportPositionSpecRepository)
    {
        parent::__construct('sport_position_spec');
        $this->sportPositionSpecRepository = $sportPositionSpecRepository;
    }

    /**
     * Find all positions translated
     */
    public function findAllTranslated($positionId)
    {
        $locale = app()->getLocale();

        return $this->cache::remember($this->key . $locale, self::TTL, function() use ($positionId) {
            return $this->sportPositionSpecRepository->findAllTranslated($positionId);
        });
    }
}