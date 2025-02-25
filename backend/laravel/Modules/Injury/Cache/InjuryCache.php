<?php

namespace Modules\Injury\Cache;

use App\Cache\BaseCache;
use Modules\Injury\Repositories\Interfaces\InjurySeverityRepositoryInterface;

class InjuryCache extends BaseCache 
{
    /**
     * @var object
     */
    protected $injurySeverityRepository;

    public function __construct(InjurySeverityRepositoryInterface $injurySeverityRepository)
    {
        parent::__construct('injury');

        $this->injurySeverityRepository = $injurySeverityRepository;
    }

    /**
     * Retrieve all severity injury only code
     */
    public function getAllSeveritiesInjuryCode()
    {
        $key = sprintf("%s_all_severity_code_%s", $this->key, app()->getLocale());

        return $this->cache::remember($key, self::TTL, function() {
            return $this->injurySeverityRepository->findAll()->pluck('code');
        });
    }

}