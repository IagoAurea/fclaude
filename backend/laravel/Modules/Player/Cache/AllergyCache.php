<?php

namespace Modules\Player\Cache;

use App\Cache\BaseCache;
use Modules\Player\Repositories\Interfaces\AllergyRepositoryInterface;

class AllergyCache extends BaseCache
{
    /**
     * @var object
     */
    protected $allergyRepository;

    public function __construct(AllergyRepositoryInterface $allergyRepository)
    {
        parent::__construct('allergy');

        $this->allergyRepository = $allergyRepository;
    }


    public function findAllTranslated()
    {
        $locale = app()->getLocale();

        return $this->cache::remember($this->key . $locale, self::TTL, function() {
            return $this->allergyRepository->findAllTranslated();
        });
    }

}