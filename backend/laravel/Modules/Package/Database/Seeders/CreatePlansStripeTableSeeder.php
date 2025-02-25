<?php

namespace Modules\Package\Database\Seeders;

use App\Services\StripeService;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\Repositories\Interfaces\PackagePriceRepositoryInterface;

class CreatePlansStripeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $packageRepository;
    
    /**
     * @var object
     */
    protected $packagePriceRepository;
    
    /**
     * @var object
     */
    protected $stripe;

    public function __construct(
        PackageRepositoryInterface $packageRepository, 
        PackagePriceRepositoryInterface $packagePriceRepository, 
        StripeService $stripe
    )
    {
        $this->packageRepository = $packageRepository;
        $this->packagePriceRepository = $packagePriceRepository;
        $this->stripe = $stripe;
    }

    /**
     * @return void
     */
    protected function createPlan()
    {
        $packages = $this->packageRepository->findAllTranslated()->toArray();

        foreach($packages as $pack) 
        {
            foreach($pack['subpackages'] as $subpackage) 
            {
                $product = $this->stripe->createProduct([
                    'name' => $subpackage['name'],
                    'description' => 'Paquete ' . $subpackage['name']
                ]);

                if($product) {
                    $prices = $subpackage['prices'];

                    $dataMonth = [
                        'product' => $product->id,
                        'nickname' => $subpackage['name'] . ' Mensual',
                        'interval' => 'month',
                        'tiers' => []
                    ];

                    $dataYear = [
                        'product' => $product->id,
                        'nickname' => $subpackage['name'] . ' Anual',
                        'interval' => 'year',
                        'tiers' => []
                    ];

                    foreach($prices as $price)
                    {
                        $numberLicenses = $price['max_licenses'] > 10 ? 'inf' : $price['max_licenses'];

                        $dataPriceMonth = [
                            'unit_amount' => (string)(round($price['monthly'] * 100)),
                            'up_to' => $numberLicenses
                        ];

                        $dataPriceYear = [
                            'unit_amount' => (string)(round($price['yearly'] * 100)),
                            'up_to' => $numberLicenses
                        ];

                        array_push($dataMonth['tiers'],  $dataPriceMonth);
                        array_push($dataYear['tiers'],  $dataPriceYear);
                    }

                    $intervals = ['dataMonth', 'dataYear'];

                    foreach($intervals as $interval)
                    {
                        $this->createStripePlan($subpackage['id'], ${$interval});
                    }
                }
            }
        }
    }

    /**
     * Create plan in stripe
     * @return void
     */
    protected function createStripePlan($idSubpackage, $dataPlan)
    {
        $dataPlan['currency'] = 'eur';
        $dataPlan['usage_type'] = 'licensed';
        $dataPlan['billing_scheme'] = 'tiered';
        $dataPlan['tiers_mode'] = 'volume';
        $dataPlan['expand'] = ['tiers'];

        $plan = $this->stripe->createPlan($dataPlan);

        $this->updateSubpackage($plan, $idSubpackage);
    }

    /**
     * Update ID plan de stripe in subpackage
     */
    protected function updateSubpackage($plan, $idSubpackage)
    {
        $dataUpdate = [ 'stripe_' . $plan['interval'] . '_id' => $plan['id']];

        $this->packagePriceRepository->update($dataUpdate, ['subpackage_id' => $idSubpackage], true);
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPlan();
    }
}
