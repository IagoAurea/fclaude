<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Services\BaseSeeder;
use Modules\Generality\Repositories\Interfaces\TaxRepositoryInterface;

class TaxTableSeeder extends BaseSeeder
{

    /**
     * @var object
     */
    protected $taxRepository;

    public function __construct(TaxRepositoryInterface $taxRepository)
    {
        $this->taxRepository = $taxRepository;
    }

    /**
     * @return void
     */
    protected function createTax(array $elements)
    {
        foreach ($elements as $elm)
        {
            $this->taxRepository->createTax($elm);
        }
    }

     /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'name' => 'VAT',
                'value' => '17',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '127',
                'stripe_tax_id' => 'txr_1N6erZK6ttgcW7bgl2mtekok'
                // 'stripe_tax_id' => 'txr_1NGkdXK6ttgcW7bg5WKpiOZn' #production
            ],

            [
                'name' => 'VAT',
                'value' => '18',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '135',
                'stripe_tax_id' => 'txr_1N6erJK6ttgcW7bgcN66cHs0'
                // 'stripe_tax_id' => 'txr_1NGke1K6ttgcW7bgMqHGeCoo' #production
            ],

            [
                'name' => 'VAT',
                'value' => '19',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '82',
                'stripe_tax_id' => 'txr_1N6er3K6ttgcW7bgp9UJtsBr'
                // 'stripe_tax_id' => 'txr_1NGkxQK6ttgcW7bgGIB8jLD1' #production
            ],
            [
                'name' => 'VAT',
                'value' => '19',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '181',
                'stripe_tax_id' => 'txr_1N6er3K6ttgcW7bgp9UJtsBr'
                // 'stripe_tax_id' => 'txr_1NGkxQK6ttgcW7bgGIB8jLD1' #production
            ],

            [
                'name' => 'VAT',
                'value' => '20',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '15',
                'stripe_tax_id' => 'txr_1N6eqZK6ttgcW7bgSzstkhFM'
                // 'stripe_tax_id' => 'txr_1NGkxtK6ttgcW7bg2N8EsAou' #production
            ],
            [
                'name' => 'VAT',
                'value' => '20',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '34',
                'stripe_tax_id' => 'txr_1N6eqZK6ttgcW7bgSzstkhFM'
                // 'stripe_tax_id' => 'txr_1NGkxtK6ttgcW7bg2N8EsAou' #production
            ],
            [
                'name' => 'VAT',
                'value' => '20',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '75',
                'stripe_tax_id' => 'txr_1N6eqZK6ttgcW7bgSzstkhFM'
                // 'stripe_tax_id' => 'txr_1NGkxtK6ttgcW7bg2N8EsAou' #production
            ],
            [
                'name' => 'VAT',
                'value' => '20',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '69',
                'stripe_tax_id' => 'txr_1N6eqZK6ttgcW7bgSzstkhFM'
                // 'stripe_tax_id' => 'txr_1NGkxtK6ttgcW7bg2N8EsAou' #production
            ],
            [
                'name' => 'VAT',
                'value' => '20',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '200',
                'stripe_tax_id' => 'txr_1N6eqZK6ttgcW7bgSzstkhFM'
                // 'stripe_tax_id' => 'txr_1NGkxtK6ttgcW7bg2N8EsAou' #production
            ],
            [
                'name' => 'VAT',
                'value' => '20',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '232',
                'stripe_tax_id' => 'txr_1N6eqZK6ttgcW7bgSzstkhFM'
                // 'stripe_tax_id' => 'txr_1NGkxtK6ttgcW7bg2N8EsAou' #production
            ],

            [
                'name' => 'VAT',
                'value' => '21',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '22',
                'stripe_tax_id' => 'txr_1N6YtOK6ttgcW7bgWSp9Xvrx'
                // 'stripe_tax_id' => 'txr_1NGkyKK6ttgcW7bgNFCLkAMS' #production
            ],
            [
                'name' => 'VAT',
                'value' => '21',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '58',
                'stripe_tax_id' => 'txr_1N6YtOK6ttgcW7bgWSp9Xvrx'
                // 'stripe_tax_id' => 'txr_1NGkyKK6ttgcW7bgNFCLkAMS' #production
            ],
            [
                'name' => 'VAT',
                'value' => '21',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '126',
                'stripe_tax_id' => 'txr_1N6YtOK6ttgcW7bgWSp9Xvrx'
                // 'stripe_tax_id' => 'txr_1NGkyKK6ttgcW7bgNFCLkAMS' #production
            ],
            [
                'name' => 'VAT',
                'value' => '21',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '120',
                'stripe_tax_id' => 'txr_1N6YtOK6ttgcW7bgWSp9Xvrx'
                // 'stripe_tax_id' => 'txr_1NGkyKK6ttgcW7bgNFCLkAMS' #production
            ],
            [
                'name' => 'VAT',
                'value' => '21',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '156',
                'stripe_tax_id' => 'txr_1N6YtOK6ttgcW7bgWSp9Xvrx'
                // 'stripe_tax_id' => 'txr_1NGkyKK6ttgcW7bgNFCLkAMS' #production
            ],
            [
                'name' => 'VAT',
                'value' => '22',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '107',
                'stripe_tax_id' => 'txr_1N6bsmK6ttgcW7bg4hYZKiFn'
                // 'stripe_tax_id' => 'txr_1NGkyuK6ttgcW7bgQy6HMA24' #production
            ],
            [
                'name' => 'VAT',
                'value' => '22',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '201',
                'stripe_tax_id' => 'txr_1N6bsmK6ttgcW7bg4hYZKiFn'
                // 'stripe_tax_id' => 'txr_1NGkyuK6ttgcW7bgQy6HMA24' #production
            ],
            [
                'name' => 'VAT',
                'value' => '23',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '105',
                'stripe_tax_id' => 'txr_1N6eoGK6ttgcW7bgJKVOx9Fm'
                // 'stripe_tax_id' => 'txr_1NGkz9K6ttgcW7bguOjzn1Z0' #production
            ],
            [
                'name' => 'VAT',
                'value' => '23',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '176',
                'stripe_tax_id' => 'txr_1N6eoGK6ttgcW7bgJKVOx9Fm'
                // 'stripe_tax_id' => 'txr_1NGkz9K6ttgcW7bguOjzn1Z0' #production
            ],
            [
                'name' => 'VAT',
                'value' => '23',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '177',
                'stripe_tax_id' => 'txr_1N6eoGK6ttgcW7bgJKVOx9Fm'
                // 'stripe_tax_id' => 'txr_1NGkz9K6ttgcW7bguOjzn1Z0' #production
            ],
            [
                'name' => 'VAT',
                'value' => '24',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '85',
                'stripe_tax_id' => 'txr_1N6eorK6ttgcW7bgOin67rMw'
                // 'stripe_tax_id' => 'txr_1NGl01K6ttgcW7bgZFADVIM5' #production
            ],
            [
                'name' => 'VAT',
                'value' => '25',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '59',
                'stripe_tax_id' => 'txr_1N6ep5K6ttgcW7bgUO7UGvff'
                // 'stripe_tax_id' => 'txr_1NGl0IK6ttgcW7bg1FQc8Y9b' #production
            ],
            [
                'name' => 'VAT',
                'value' => '25',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '55',
                'stripe_tax_id' => 'txr_1N6ep5K6ttgcW7bgUO7UGvff'
                // 'stripe_tax_id' => 'txr_1NGl0IK6ttgcW7bg1FQc8Y9b' #production
            ],
            [
                'name' => 'VAT',
                'value' => '25',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '213',
                'stripe_tax_id' => 'txr_1N6ep5K6ttgcW7bgUO7UGvff'
                // 'stripe_tax_id' => 'txr_1NGl0IK6ttgcW7bg1FQc8Y9b' #production
            ],
            [
                'name' => 'VAT',
                'value' => '27',
                'type' => '1',
                'type_user' => true,
                'taxable_id' => '99',
                'stripe_tax_id' => 'txr_1N6epxK6ttgcW7bg58esOi2X'
                // 'stripe_tax_id' => 'txr_1NGl0eK6ttgcW7bgffKfyYGY' #production
            ],
            [
                'name' => 'IGIC',
                'value' => '7',
                'type' => '2',
                'type_user' => true,
                'taxable_id' => '3785',
                'stripe_tax_id' => 'txr_1N6euXK6ttgcW7bg6nxBGhoF'
                // 'stripe_tax_id' => 'txr_1NGkOpK6ttgcW7bgo7N7YBtX' #production
            ],
            [
                'name' => 'IGIC',
                'value' => '7',
                'type' => '2',
                'type_user' => false,
                'taxable_id' => '3785',
                'stripe_tax_id' => 'txr_1N6euXK6ttgcW7bg6nxBGhoF'
                // 'stripe_tax_id' => 'txr_1NGkOpK6ttgcW7bgo7N7YBtX' #production
            ],
            [
                'name' => 'IGIC',
                'value' => '7',
                'type' => '2',
                'type_user' => true,
                'taxable_id' => '3808',
                'stripe_tax_id' => 'txr_1N6euXK6ttgcW7bg6nxBGhoF'
                // 'stripe_tax_id' => 'txr_1NGkOpK6ttgcW7bgo7N7YBtX' #production
            ],
            [
                'name' => 'IGIC',
                'value' => '7',
                'type' => '2',
                'type_user' => false,
                'taxable_id' => '3808',
                'stripe_tax_id' => 'txr_1N6euXK6ttgcW7bg6nxBGhoF'
                // 'stripe_tax_id' => 'txr_1NGkOpK6ttgcW7bgo7N7YBtX' #production
            ],
            [
                'name' => 'IVA',
                'value' => '21',
                'type' => '3',
                'type_user' => true,
                'taxable_id' => '207',
                'stripe_tax_id' => 'txr_1N6etqK6ttgcW7bg9Q2sBg3D'
                // 'stripe_tax_id' => 'txr_1NGkVBK6ttgcW7bgkxnpSW7c' #production
            ],
            [
                'name' => 'VAT',
                'value' => '0',
                'type' => '4',
                'type_user' => true,
                'taxable_id' => '239',
                'stripe_tax_id' => 'txr_1N6esJK6ttgcW7bgG5XVT3BH'
                // 'stripe_tax_id' => 'txr_1NGkayK6ttgcW7bgzj0mBuKd' #production
            ],
            [
                'name' => 'VAT',
                'value' => '0',
                'type' => '4',
                'type_user' => false,
                'taxable_id' => '239',
                'stripe_tax_id' => 'txr_1N6esJK6ttgcW7bgG5XVT3BH'
                // 'stripe_tax_id' => 'txr_1NGkayK6ttgcW7bgzj0mBuKd' #production
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
        $this->createTax($this->get()->current());
    }
}
