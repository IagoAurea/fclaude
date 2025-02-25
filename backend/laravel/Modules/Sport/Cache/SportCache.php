<?php

namespace Modules\Sport\Cache;

use App\Cache\BaseCache;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;

class SportCache extends BaseCache
{
    /**
     * @var object
     */
    protected $sportRepository;

    public function __construct(SportRepositoryInterface $sportRepository)
    {
        parent::__construct('sport');

        $this->sportRepository = $sportRepository;
    }

    public function findBy($filter)
    {
        $has_scouting = isset($filter['has_scouting']) ?
            ($filter['has_scouting']) ? '1': '0' :
            'all';

        $has_code = $filter['has_code'] ?? '';

        $key = $this->key . '_' .  $has_code . $has_scouting . '_' . app()->getLocale();

        return $this->cache::remember($key, self::TTL, function() use($filter) {
            return $this->sportRepository->findBy($filter);
        });
    }

    public function findAllTranslated()
    {
        $locale = app()->getLocale();

        return $this->cache::remember($this->key . $locale, self::TTL, function() {
            return $this->sportRepository->findAllTranslated();
        });
    }

}