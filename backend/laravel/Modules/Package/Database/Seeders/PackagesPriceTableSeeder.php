<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Package\Repositories\Interfaces\PackagePriceRepositoryInterface;
use Modules\Package\Repositories\Interfaces\SubpackageRepositoryInterface;

class PackagesPriceTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $packagePriceRepository;
    
    /**
     * @var object
     */
    protected $subpackageRepository;

    /**
     * Create a new seeder instance
     */
    public function __construct(
        PackagePriceRepositoryInterface $packagePriceRepository,
        SubpackageRepositoryInterface $subpackageRepository
    ) {
        $this->packagePriceRepository = $packagePriceRepository;
        $this->subpackageRepository = $subpackageRepository;
    }

    /**
     * @return void
     */
    protected function createPackagesPrice(array $elements)
    {
        $subpackages = $this->subpackageRepository->findAll();

        foreach ($subpackages as $subpack) {
            foreach ($elements as $elm) {
                if ($elm['subpackage'] === $subpack['code']) {
                    $elm['subpackage_id'] = $subpack['id'];
                    unset($elm['subpackage']);

                    $this->packagePriceRepository->create($elm);
                }
            }
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'code' => 'sport_bronze_coach_1_1',
                'subpackage' => 'sport_bronze',
                'name' => 'coach',
                'min_licenses' => 1,
                'max_licenses' => 1,
                'month' => 6.99,
                'year' => 62.91,
                'stripe_month_id' => 'plan_JVXUveWfFyN6sg',
                'stripe_year_id' => 'plan_JVXURO912X8ZCR'
                // 'stripe_month_id' => 'price_1NGheFK6ttgcW7bgLTJE0kFW', #production
                // 'stripe_year_id' => 'price_1NGhtyK6ttgcW7bgJzL92h40' #production
            ],
            [
                'code' => 'sport_bronze_team_2_5',
                'subpackage' => 'sport_bronze',
                'name' => 'team',
                'min_licenses' => 2,
                'max_licenses' => 5,
                'month' => 5.99,
                'year' => 53.91,
                'stripe_month_id' => 'plan_JVXUveWfFyN6sg',
                'stripe_year_id' => 'plan_JVXURO912X8ZCR'
                // 'stripe_month_id' => 'price_1NGheFK6ttgcW7bgLTJE0kFW', #production
                // 'stripe_year_id' => 'price_1NGhtyK6ttgcW7bgJzL92h40' #production
            ],
            [
                'code' => 'sport_bronze_club_6_10',
                'subpackage' => 'sport_bronze',
                'name' => 'club',
                'min_licenses' => 6,
                'max_licenses' => 10,
                'month' => 4.99,
                'year' => 44.91,
                'stripe_month_id' => 'plan_JVXUveWfFyN6sg',
                'stripe_year_id' => 'plan_JVXURO912X8ZCR'
                // 'stripe_month_id' => 'price_1NGheFK6ttgcW7bgLTJE0kFW', #production
                // 'stripe_year_id' => 'price_1NGhtyK6ttgcW7bgJzL92h40' #production
            ],
            [
                'code' => 'sport_bronze_customized_11_99',
                'subpackage' => 'sport_bronze',
                'name' => 'customized',
                'min_licenses' => 11,
                'max_licenses' => 999,
                'month' => 3.99,
                'year' => 35.91,
                'stripe_month_id' => 'plan_JVXUveWfFyN6sg',
                'stripe_year_id' => 'plan_JVXURO912X8ZCR'
                // 'stripe_month_id' => 'price_1NGheFK6ttgcW7bgLTJE0kFW', #production
                // 'stripe_year_id' => 'price_1NGhtyK6ttgcW7bgJzL92h40' #production
            ],
            [
                'code' => 'sport_silver_coach_1_1',
                'subpackage' => 'sport_silver',
                'name' => 'coach',
                'min_licenses' => 1,
                'max_licenses' => 1,
                'month' => 9.99,
                'year' => 89.91,
                'stripe_month_id' => 'plan_JVXU6afVm1T3GZ',
                'stripe_year_id' => 'plan_JVXUIJLCY82pIY'
                // 'stripe_month_id' => 'price_1NGiB2K6ttgcW7bgzNxmLCqr', #production
                // 'stripe_year_id' => 'price_1NGiJbK6ttgcW7bgWneb4RsE' #production
            ],
            [
                'code' => 'sport_silver_team_2_5',
                'subpackage' => 'sport_silver',
                'name' => 'team',
                'min_licenses' => 2,
                'max_licenses' => 5,
                'month' => 8.99,
                'year' => 80.91,
                'stripe_month_id' => 'plan_JVXU6afVm1T3GZ',
                'stripe_year_id' => 'plan_JVXUIJLCY82pIY'
                // 'stripe_month_id' => 'price_1NGiB2K6ttgcW7bgzNxmLCqr', #production
                // 'stripe_year_id' => 'price_1NGiJbK6ttgcW7bgWneb4RsE' #production
            ],
            [
                'code' => 'sport_silver_club_6_10',
                'subpackage' => 'sport_silver',
                'name' => 'club',
                'min_licenses' => 6,
                'max_licenses' => 10,
                'month' => 7.99,
                'year' => 71.91,
                'stripe_month_id' => 'plan_JVXU6afVm1T3GZ',
                'stripe_year_id' => 'plan_JVXUIJLCY82pIY'
                // 'stripe_month_id' => 'price_1NGiB2K6ttgcW7bgzNxmLCqr', #production
                // 'stripe_year_id' => 'price_1NGiJbK6ttgcW7bgWneb4RsE' #production
            ],
            [
                'code' => 'sport_silver_customized_11_99',
                'subpackage' => 'sport_silver',
                'name' => 'customized',
                'min_licenses' => 11,
                'max_licenses' => 999,
                'month' => 6.99,
                'year' => 62.91,
                'stripe_month_id' => 'plan_JVXU6afVm1T3GZ',
                'stripe_year_id' => 'plan_JVXUIJLCY82pIY'
                // 'stripe_month_id' => 'price_1NGiB2K6ttgcW7bgzNxmLCqr', #production
                // 'stripe_year_id' => 'price_1NGiJbK6ttgcW7bgWneb4RsE' #production
            ],
            [
                'code' => 'sport_gold_coach_1_1',
                'subpackage' => 'sport_gold',
                'name' => 'coach',
                'min_licenses' => 1,
                'max_licenses' => 1,
                'month' => 15.99,
                'year' => 143.91,
                'stripe_month_id' => 'plan_JVXUsNPMEyeAbD',
                'stripe_year_id' => 'plan_JVXUbHaeL16C9L'
                // 'stripe_month_id' => 'price_1NGinWK6ttgcW7bgFT6Nl1DO', #production
                // 'stripe_year_id' => 'price_1NGip1K6ttgcW7bgtvpJm7xw' #production
            ],
            [
                'code' => 'sport_gold_team_2_5',
                'subpackage' => 'sport_gold',
                'name' => 'team',
                'min_licenses' => 2,
                'max_licenses' => 5,
                'month' => 14.99,
                'year' => 134.91,
                'stripe_month_id' => 'plan_JVXUsNPMEyeAbD',
                'stripe_year_id' => 'plan_JVXUbHaeL16C9L'
                // 'stripe_month_id' => 'price_1NGinWK6ttgcW7bgFT6Nl1DO', #production
                // 'stripe_year_id' => 'price_1NGip1K6ttgcW7bgtvpJm7xw' #production
            ],
            [
                'code' => 'sport_gold_club_6_10',
                'subpackage' => 'sport_gold',
                'name' => 'club',
                'min_licenses' => 6,
                'max_licenses' => 10,
                'month' => 13.99,
                'year' => 125.91,
                'stripe_month_id' => 'plan_JVXUsNPMEyeAbD',
                'stripe_year_id' => 'plan_JVXUbHaeL16C9L'
                // 'stripe_month_id' => 'price_1NGinWK6ttgcW7bgFT6Nl1DO', #production
                // 'stripe_year_id' => 'price_1NGip1K6ttgcW7bgtvpJm7xw' #production
            ],
            [
                'code' => 'sport_gold_club_11_99',
                'subpackage' => 'sport_gold',
                'name' => 'customized',
                'min_licenses' => 11,
                'max_licenses' => 999,
                'month' => 12.99,
                'year' => 116.91,
                'stripe_month_id' => 'plan_JVXUsNPMEyeAbD',
                'stripe_year_id' => 'plan_JVXUbHaeL16C9L'
                // 'stripe_month_id' => 'price_1NGinWK6ttgcW7bgFT6Nl1DO', #production
                // 'stripe_year_id' => 'price_1NGip1K6ttgcW7bgtvpJm7xw' #production
            ],
            [
                'code' => 'teacher_bronze_coach_1_1',
                'subpackage' => 'teacher_bronze',
                'name' => 'coach',
                'min_licenses' => 1,
                'max_licenses' => 1,
                'month' => 6.99,
                'year' => 62.91,
                'stripe_month_id' => 'plan_JVXUDIEe4Jnmmd',
                'stripe_year_id' => 'plan_JVXUqn8RJhHA24'
                // 'stripe_month_id' => 'price_1NGjd8K6ttgcW7bgKaclVuD1', #production
                // 'stripe_year_id' => 'price_1NGjd9K6ttgcW7bgu5aIy2FC' #production
            ],
            [
                'code' => 'teacher_bronze_team_2_5',
                'subpackage' => 'teacher_bronze',
                'name' => 'team',
                'min_licenses' => 2,
                'max_licenses' => 5,
                'month' => 5.99,
                'year' => 53.91,
                'stripe_month_id' => 'plan_JVXUDIEe4Jnmmd',
                'stripe_year_id' => 'plan_JVXUqn8RJhHA24'
                // 'stripe_month_id' => 'price_1NGjd8K6ttgcW7bgKaclVuD1', #production
                // 'stripe_year_id' => 'price_1NGjd9K6ttgcW7bgu5aIy2FC' #production
            ],
            [
                'code' => 'teacher_bronze_club_6_10',
                'subpackage' => 'teacher_bronze',
                'name' => 'club',
                'min_licenses' => 6,
                'max_licenses' => 10,
                'month' => 4.99,
                'year' => 44.91,
                'stripe_month_id' => 'plan_JVXUDIEe4Jnmmd',
                'stripe_year_id' => 'plan_JVXUqn8RJhHA24'
                // 'stripe_month_id' => 'price_1NGjd8K6ttgcW7bgKaclVuD1', #production
                // 'stripe_year_id' => 'price_1NGjd9K6ttgcW7bgu5aIy2FC' #production
            ],
            [
                'code' => 'teacher_bronze_customized_11_99',
                'subpackage' => 'teacher_bronze',
                'name' => 'customized',
                'min_licenses' => 11,
                'max_licenses' => 999,
                'month' => 3.99,
                'year' => 35.91,
                'stripe_month_id' => 'plan_JVXUDIEe4Jnmmd',
                'stripe_year_id' => 'plan_JVXUqn8RJhHA24'
                // 'stripe_month_id' => 'price_1NGjd8K6ttgcW7bgKaclVuD1', #production
                // 'stripe_year_id' => 'price_1NGjd9K6ttgcW7bgu5aIy2FC' #production
            ],
            [
                'code' => 'teacher_silver_coach_1_1',
                'subpackage' => 'teacher_silver',
                'name' => 'coach',
                'min_licenses' => 1,
                'max_licenses' => 1,
                'month' => 9.99,
                'year' => 89.91,
                'stripe_month_id' => 'plan_JVXUYMcqusavn1',
                'stripe_year_id' => 'plan_JVXUvrR8Fp89eR'
                // 'stripe_month_id' => 'price_1NGjmzK6ttgcW7bgKhGpDyHz', #production
                // 'stripe_year_id' => 'price_1NGjmzK6ttgcW7bgq7ovjgo9' #production
            ],
            [
                'code' => 'teacher_silver_team_2_5',
                'subpackage' => 'teacher_silver',
                'name' => 'team',
                'min_licenses' => 2,
                'max_licenses' => 5,
                'month' => 8.99,
                'year' => 80.91,
                'stripe_month_id' => 'plan_JVXUYMcqusavn1',
                'stripe_year_id' => 'plan_JVXUvrR8Fp89eR'
                // 'stripe_month_id' => 'price_1NGjmzK6ttgcW7bgKhGpDyHz', #production
                // 'stripe_year_id' => 'price_1NGjmzK6ttgcW7bgq7ovjgo9' #production
            ],
            [
                'code' => 'teacher_silver_club_6_10',
                'subpackage' => 'teacher_silver',
                'name' => 'club',
                'min_licenses' => 6,
                'max_licenses' => 10,
                'month' => 7.99,
                'year' => 71.91,
                'stripe_month_id' => 'plan_JVXUYMcqusavn1',
                'stripe_year_id' => 'plan_JVXUvrR8Fp89eR'
                // 'stripe_month_id' => 'price_1NGjmzK6ttgcW7bgKhGpDyHz', #production
                // 'stripe_year_id' => 'price_1NGjmzK6ttgcW7bgq7ovjgo9' #production
            ],
            [
                'code' => 'teacher_silver_customized_11_99',
                'subpackage' => 'teacher_silver',
                'name' => 'customized',
                'min_licenses' => 11,
                'max_licenses' => 999,
                'month' => 6.99,
                'year' => 62.91,
                'stripe_month_id' => 'plan_JVXUYMcqusavn1',
                'stripe_year_id' => 'plan_JVXUvrR8Fp89eR'
                // 'stripe_month_id' => 'price_1NGjmzK6ttgcW7bgKhGpDyHz', #production
                // 'stripe_year_id' => 'price_1NGjmzK6ttgcW7bgq7ovjgo9' #production
            ],
            [
                'code' => 'teacher_gold_coach_1_1',
                'subpackage' => 'teacher_gold',
                'name' => 'coach',
                'min_licenses' => 1,
                'max_licenses' => 1,
                'month' => 15.99,
                'year' => 143.91,
                'stripe_month_id' => 'plan_JVXUnpzf2aPJ2u',
                'stripe_year_id' => 'plan_JVXUp3SVtbUjsn'
                // 'stripe_month_id' => 'price_1NGk9RK6ttgcW7bgrvapINkQ', #production
                // 'stripe_year_id' => 'price_1NGk9RK6ttgcW7bgfW2QSDTE' #production
            ],
            [
                'code' => 'teacher_gold_team_2_5',
                'subpackage' => 'teacher_gold',
                'name' => 'team',
                'min_licenses' => 2,
                'max_licenses' => 5,
                'month' => 14.99,
                'year' => 134.91,
                'stripe_month_id' => 'plan_JVXUnpzf2aPJ2u',
                'stripe_year_id' => 'plan_JVXUp3SVtbUjsn'
                // 'stripe_month_id' => 'price_1NGk9RK6ttgcW7bgrvapINkQ', #production
                // 'stripe_year_id' => 'price_1NGk9RK6ttgcW7bgfW2QSDTE' #production
            ],
            [
                'code' => 'teacher_gold_club_6_10',
                'subpackage' => 'teacher_gold',
                'name' => 'club',
                'min_licenses' => 6,
                'max_licenses' => 10,
                'month' => 13.99,
                'year' => 125.91,
                'stripe_month_id' => 'plan_JVXUnpzf2aPJ2u',
                'stripe_year_id' => 'plan_JVXUp3SVtbUjsn'
                // 'stripe_month_id' => 'price_1NGk9RK6ttgcW7bgrvapINkQ', #production
                // 'stripe_year_id' => 'price_1NGk9RK6ttgcW7bgfW2QSDTE' #production
            ],
            [
                'code' => 'teacher_gold_club_11_99',
                'subpackage' => 'teacher_gold',
                'name' => 'customized',
                'min_licenses' => 11,
                'max_licenses' => 999,
                'month' => 12.99,
                'year' => 116.91,
                'stripe_month_id' => 'plan_JVXUnpzf2aPJ2u',
                'stripe_year_id' => 'plan_JVXUp3SVtbUjsn'
                // 'stripe_month_id' => 'price_1NGk9RK6ttgcW7bgrvapINkQ', #production
                // 'stripe_year_id' => 'price_1NGk9RK6ttgcW7bgfW2QSDTE' #production
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPackagesPrice($this->get()->current());
    }
}
