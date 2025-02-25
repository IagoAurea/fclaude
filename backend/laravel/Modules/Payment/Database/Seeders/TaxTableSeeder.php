<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\Repositories\Interfaces\TaxRepositoryInterface;

class TaxTableSeeder extends Seeder
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
        foreach($elements as $elm)
        {
            $this->taxRepository->create($elm);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'type' => 'UNO',
                'value' => 100
            ],
            [
                'type' => 'DOS',
                'value' => 200
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
