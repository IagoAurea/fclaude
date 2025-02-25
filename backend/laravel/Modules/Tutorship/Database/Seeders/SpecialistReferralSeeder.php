<?php

namespace Modules\Tutorship\Database\Seeders;

use Modules\Tutorship\Database\Seeders\Fixtures\SpecialistReferralFixturesTrait;
use Modules\Tutorship\Services\Interfaces\SpecialistReferralServiceInterface;
use App\Services\BaseSeeder;

class SpecialistReferralSeeder extends BaseSeeder
{
    use SpecialistReferralFixturesTrait;
    /**
     * @var $specialistReferralService
     */
    protected $specialistReferralService;
    public function __construct(
        SpecialistReferralServiceInterface $specialistReferralService
    ) {
        $this->specialistReferralService = $specialistReferralService;
    }

    /**
     * @return void
     */
    protected function createSpecialistReferrals(array $specialist_referrals)
    {
        foreach ($specialist_referrals as $specialist_referral) {
            $specialist_referral_payload = [
                'code' => $specialist_referral['code'],
                'en' => [
                    'name' => $specialist_referral['en_name']
                ],
                'es' => [
                    'name' => $specialist_referral['es_name']
                ]
            ];

            $this->specialistReferralService->store($specialist_referral_payload);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSpecialistReferrals($this->getSpecialistReferrals());
    }
}
