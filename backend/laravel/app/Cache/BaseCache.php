<?php

namespace App\Cache;

use Illuminate\Support\Facades\Cache;

class BaseCache
{
    const TTL = 86400;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var object
     */
    protected $cache;

    public function __construct(String $key)
    {
        $this->key = $key;
        $this->cache = new Cache();
    }
}