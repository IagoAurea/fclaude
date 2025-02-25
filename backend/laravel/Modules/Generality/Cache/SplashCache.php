<?php

namespace Modules\Generality\Cache;

use App\Cache\BaseCache;
use Modules\Generality\Repositories\Interfaces\SplashRepositoryInterface;

class SplashCache extends BaseCache
{
    /**
     * @var object
     */
    protected $splashRepository;

    public function __construct(SplashRepositoryInterface $splashRepository)
    {
        parent::__construct('splash');

        $this->splashRepository = $splashRepository;
    }

    public function findByType($type)
    {
        $key = sprintf('%s-%s-%s', $this->key, app()->getLocale(), $type);

        return $this->cache::remember($key, self::TTL, function() use($type) {
            $isExternal = $type == 'external';

            return $this->splashRepository->findBy([
                'active' => true,
                'external' => $isExternal
            ]);
        });


        
    }
}