<?php

namespace Modules\Player\Cache;

use App\Cache\BaseCache;
use Modules\Player\Repositories\Interfaces\DiseaseRepositoryInterface;

class DiseaseCache extends BaseCache 
{
    /**
     * @var object
     */
    protected $diseaseRepository;

    public function __construct(DiseaseRepositoryInterface $diseaseRepository)
    {
        parent::__construct('disease');

        $this->diseaseRepository = $diseaseRepository;
    }


    public function findAllTranslated()
    {
        $locale = app()->getLocale();

        return $this->cache::remember($this->key . $locale, self::TTL, function() {
            return $this->diseaseRepository->findAllTranslated();
        });
    }

}