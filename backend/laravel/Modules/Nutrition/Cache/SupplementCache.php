<?php

namespace Modules\Nutrition\Cache;

use App\Cache\BaseCache;
use Modules\Nutrition\Repositories\Interfaces\SupplementRepositoryInterface;

class SupplementCache extends BaseCache
{
    /**
     * @var object
     */
    protected $supplementRepository;

    public function __construct(SupplementRepositoryInterface $supplementRepository)
    {
        parent::__construct('supplement');

        $this->supplementRepository = $supplementRepository;
    }


    public function findAllTranslated()
    {
        $locale = app()->getLocale();

        return $this->cache::remember($this->key . $locale, self::TTL, function() {
            return $this->supplementRepository->findAllTranslated();
        });
    }

}