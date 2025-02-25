<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\BusinessRepositoryInterface;

class BusinessTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $businessRepository;
    
    /**
     * @var object
     */
    protected $countryRepository;

     /**
     * Creates a new seeder instance
     */
    public function __construct(
        BusinessRepositoryInterface $businessRepository,
        CountryRepositoryInterface $countryRepository
    ) {
        $this->businessRepository = $businessRepository;
        $this->countryRepository = $countryRepository;
    }

    private function createBusiness($business)
    {
        $this->businessRepository->create($business);
    }

    private function get()
    {
        $country = $this->countryRepository->findOneBy(['iso2' => 'es']);

        return [
            'name' => 'Fisicalcoach, S.L',
            'cif' => 'B01836626',
            'address' => 'Calle Ruiz de Padrón, 48. San Sebastián de la Gomera, S/Cruz de Tenerife.',
            'code_postal' => '38800',
            'phone' => '+34 616 64 85 18',
            'city' => 'Tenerife',
            'country_id' => $country->id
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createBusiness($this->get());
    }
}
