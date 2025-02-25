<?php

namespace Modules\Generality\Cache;

use App\Cache\BaseCache;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;

class CountryCache extends BaseCache 
{
    /**
     * @var object
     */
    protected $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        parent::__construct('country');

        $this->countryRepository = $countryRepository;
    }


    public function findTranslatedByTerm($term = null)
    {
        $locale = app()->getLocale();

        return $this->cache::remember($this->key. $locale .$term, self::TTL, function() use($term) {
            return $this->countryRepository->findTranslatedByTerm($term);
        });
    }

}