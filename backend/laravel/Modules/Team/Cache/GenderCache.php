<?php

namespace Modules\Team\Cache;

use App\Cache\BaseCache;
use Modules\Team\Repositories\Interfaces\TeamRepositoryInterface;

class GenderCache extends BaseCache
{
    /**
     * @var object
     */
    protected $genderRepository;

    public function __construct(TeamRepositoryInterface $genderRepository)
    {
        parent::__construct('gender');

        $this->genderRepository = $genderRepository;
    }

    public function findAllTranslated()
    {
        $key = $this->key . '_' . app()->getLocale();

        return $this->cache::remember($key, self::TTL, function() {
            return $this->genderRepository->getGenderTypes();
        });
    }

}