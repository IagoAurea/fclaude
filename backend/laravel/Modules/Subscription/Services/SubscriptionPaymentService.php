<?php

namespace Modules\Subscription\Services;

use Exception;
use Illuminate\Http\Response;
use Modules\Team\Entities\Team;
use App\Traits\TranslationTrait;
use Modules\User\Cache\UserCache;
use Illuminate\Support\Facades\DB;
use Modules\Player\Entities\Player;
use Modules\Injury\Entities\InjuryRfd;
use Modules\Exercise\Entities\Exercise;
use Modules\Fisiotherapy\Entities\File;
use Modules\Tutorship\Entities\Tutorship;
use Modules\Test\Entities\TestApplication;
use Modules\Training\Entities\ExerciseSession;
use Modules\Nutrition\Entities\NutritionalSheet;
use Modules\Subscription\Cache\SubscriptionCache;
use Modules\Subscription\Services\LicenseService;
use Modules\Psychology\Entities\PsychologyReport;
use Modules\Competition\Entities\CompetitionMatch;
use Modules\EffortRecovery\Entities\EffortRecovery;
use Modules\InjuryPrevention\Entities\InjuryPrevention;
use Modules\Payment\Repositories\Interfaces\PaymentRepositoryInterface;
use Modules\Package\Repositories\Interfaces\PackagePriceRepositoryInterface;
use Modules\Subscription\Repositories\Interfaces\SubscriptionRepositoryInterface;

class SubscriptionPaymentService
{
    use TranslationTrait;

    /**
     * @var LicenseService
     */
    protected $licenseService;
    
    /**
     * @var PaymentRepositoryInterface
     */
    protected $paymentRepository;

    /**
     * @var SubscriptionRepositoryInterface
     */
    protected $subscriptionRepository;

    /**
     * @var PackagePriceRepositoryInterface
     */
    protected $packagePriceRepository;

    /**
     * @var $subscriptionCache
     */
    protected $subscriptionCache;

    /**
     * @var $userCache
     */
    protected $userCache;

    /**
     * Creates a new service instance
     */
    public function __construct(
        LicenseService $licenseService,
        PaymentRepositoryInterface $paymentRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        PackagePriceRepositoryInterface $packagePriceRepository,
        SubscriptionCache $subscriptionCache,
        UserCache $userCache
    ) {
        $this->licenseService = $licenseService;
        $this->paymentRepository = $paymentRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->packagePriceRepository = $packagePriceRepository;
        $this->subscriptionCache = $subscriptionCache;
        $this->userCache = $userCache;
    }

    /**
     * Updates an existent subscription in order to change its internal prices
     * @return bool
     *
     * @OA\Schema(
     *  schema="SubscriptionPriceUpdateResponse",
     *  type="object",
     *  description="Retrieves the result of subscription updating",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="Subscription updated"),
     *  @OA\Property(
     *      property="data", type="boolean", example="true"
     *  ),
     * )
     */
    public function update($requestData, $user)
    {
        $packagePrice = $this->packagePriceRepository->findOneBy([
            'id' => $requestData['package_price_id']
        ]);

        $currentSubscription = $user->activeSubscriptionByType($requestData['type']);

        if ($currentSubscription->quantity < $packagePrice->min_licenses ||
            $currentSubscription->quantity > $packagePrice->max_licenses) {
            throw new Exception(
                $this->translator('licenses_not_range_package'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        try {
            $user->subscription($requestData['type'])
                ->swap($packagePrice['stripe_' . $requestData['interval'] . '_id']);
    
            $this->subscriptionRepository->update([
                'package_price_id' => $requestData['package_price_id'],
                'interval' => $requestData['interval'],
                'amount' => $packagePrice[$requestData['interval']] * $currentSubscription->quantity,
                'stripe_price' => $packagePrice['stripe_' . $requestData['interval'] . '_id']
            ], [
                'stripe_id' => $currentSubscription->stripe_id
            ]);
            
            if(isset($requestData[$requestData['type']])) {
                DB::beginTransaction();

                $this->deleteElements($requestData[$requestData['type']]);
                
                DB::commit();
            }

            $this->subscriptionCache->deleteQuantityElementAvailable($user->id, $requestData['type']);

            $this->userCache->deleteUserData($user->id);

        } catch (Exception $exception) {
            DB::rollBack();

            throw new Exception(
               $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return true;
    }

    /**
     * Delete every element define package subscription
     */
    private function deleteElements($elements)
    {
        foreach($elements as $element => $value) {
            $class = $this->getClassElement($element);

            if(is_null($class)) { continue; }

            $class->find($value)->each(function ($query) {
                $query->delete();
            });
        }
    }

    /**
     * Associate with class
     */
    private function getClassElement($name)
    {
        $elements = [
            'teams' => new Team(),
            'matches' => new CompetitionMatch(),
            'exercises' => new Exercise(),
            'exercise_sessions' => new ExerciseSession(),
            'players' => new Player(),
            'tests' => new TestApplication(),
            'injuries_prevention' => new InjuryPrevention(),
            'injuries_rfd' => new InjuryRfd(),
            'files_fisiotherapy' => new File(),
            'efforts_recovery' => new EffortRecovery(),
            'nutritional_sheets' => new NutritionalSheet(),
            'psychology_reports' => new PsychologyReport(),
            'tutorships' => new Tutorship()
        ];

        return $elements[$name] ?? null;
    }
}
