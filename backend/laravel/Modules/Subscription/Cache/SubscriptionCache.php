<?php

namespace Modules\Subscription\Cache;

use App\Cache\BaseCache;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Modules\Package\Repositories\AttributePackRepository;

class SubscriptionCache extends BaseCache
{
    /**
     * @var object
     */
    protected $attributeRepository;

    public function __construct(AttributePackRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
        parent::__construct('subscription');
    }

    public function quantityElementAvailable($user, $element, $profile = 'sport')
    {
        $key = sprintf('%s-%s-%s', $profile, $user->id, $element);

        $activeSportSubscription = $user->activeSubscriptionByType($profile);

        if (!$activeSportSubscription) {
            return 0;
        }

        return $this->cache::remember($key, self::TTL, function () use ($element, $activeSportSubscription) {
            return  $activeSportSubscription->packagePrice
                ->subpackage
                ->attributes
                ->filter(function ($item) use ($element) {
                    return $item->code == $element;
                })->first()->pivot->quantity;
        });
    }

    public function deleteQuantityElementAvailable($userId, $profile = 'sport')
    {
        $elements = $this->attributeRepository->findBy([]);

        foreach ($elements as $element) {
            $key = sprintf('%s-%s-%s', $profile, $userId, $element->code);

            $this->cache::forget($key);
        }

        return true;
    }
}
