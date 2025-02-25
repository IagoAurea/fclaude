<?php

namespace Modules\Nutrition\Cache;

use App\Cache\BaseCache;
use Modules\Nutrition\Repositories\Interfaces\DietRepositoryInterface;

class DietCache extends BaseCache
{
    /**
     * @var object
     */
    protected $dietRepository;

    public function __construct(DietRepositoryInterface $dietRepository)
    {
        parent::__construct('diet');

        $this->dietRepository = $dietRepository;
    }


    public function findAllTranslated()
    {
        $locale = app()->getLocale();

        return $this->cache::remember($this->key . $locale, self::TTL, function() {
            return $this->dietRepository->findAllTranslated();
        });
    }

}