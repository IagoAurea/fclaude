<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Services\BaseSeeder;
use Modules\Generality\Repositories\Interfaces\ProvinceRepositoryInterface;

class ProvincesTableSeeder extends BaseSeeder
{
    /**
     * @var object
     */
    protected $provinceRepository;

    /**
     * @var array
     */
    protected $provinces = [];

    public function __construct(ProvinceRepositoryInterface $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * @return void
     */
    protected function mergeProvinceTranslations()
    {
        $locales = config('translatable.locales');
        
        foreach($locales as $locale)
        {
            $filenameCountries = "all-countries-" . $locale . ".json";

            $countries = $this->getDataJson($filenameCountries);

            $filenameProvinces = "countries-by-provinces-" . $locale . ".json";

            $provinces = $this->getDataJson($filenameProvinces);

            foreach($countries as $country) {
                $existCountry = array_search($country['iso2'], array_column($provinces, 'iso2'));
                
                if($existCountry >= 0) 
                {
                    $allProvinces = $provinces[$existCountry]['states'];

                    foreach($allProvinces as $elm) {
                        if (!array_key_exists($elm['id'], $this->provinces))
                        {
                            $this->provinces[$elm['id']] = [
                                'iso2' => is_numeric($elm['iso2'])? $elm['iso2']:strtolower($elm['iso2']),
                                'country_id' =>$country['id'],
                                $locale => [
                                    'name' => $elm['name']
                                ]
                            ];
                        } else {
                            $this->provinces[$elm['id']][$locale]['name'] = $elm['name'];
                        }
                    }
                }
            }
        }
    }

     /**
     * @return void
     */
    protected function createProvince()
    {
        foreach ($this->provinces as $elm)
        {
            $this->provinceRepository->create($elm);
        }
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->mergeProvinceTranslations();
        $this->createProvince();
    }
}
