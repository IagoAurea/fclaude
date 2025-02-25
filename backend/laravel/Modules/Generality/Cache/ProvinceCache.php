<?php

namespace Modules\Generality\Cache;

use App\Cache\BaseCache;
use Modules\Generality\Repositories\Interfaces\ProvinceRepositoryInterface;

class ProvinceCache extends BaseCache
{
    /**
     * @var object
     */
    protected $provinceRepository;

    public function __construct(ProvinceRepositoryInterface $provinceRepository)
    {
        parent::__construct('province');

        $this->provinceRepository = $provinceRepository;
    }


    public function findTranslatedByCountry($country_iso2)
    {
        $key = $this->key . '_' . app()->getLocale() . '_' . $country_iso2;

        return $this->cache::remember($key, self::TTL, function() use($country_iso2) {
            return $this->provinceRepository->findByCountryAndTranslated($country_iso2);
        });
    }

}