<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Services\BaseSeeder;
use Modules\Generality\Repositories\Interfaces\CountryRepositoryInterface;

class CountriesTableSeeder extends BaseSeeder
{
    /**
     * @var object
     */
    protected $countryRepository;

    /**
     * @var array
     */
    protected $countries = [];

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * @return void
     */
    protected function mergeCountryTranslations()
    {
        $locales = config('translatable.locales');

        foreach( $locales as $locale)
        {
            $filename = "all-countries-" . $locale . ".json";

            $elements = $this->getDataJson($filename);

            foreach ($elements as $elm) {
                if (!array_key_exists($elm['id'], $this->countries))
                {
                    $this->countries[$elm['id']] = [
                        'id' =>  $elm['id'],
                        'iso2' => strtolower($elm['iso2']),
                        'iso3' => strtolower($elm['iso3']),
                        'phone_code' => $elm['phonecode'],
                        'currency' => $elm['currency'],
                        'emoji' => $elm['emoji'],
                        'emoji_u' => $elm['emojiU'],
                        'belongs_ue' => $elm['belongsUE'] ?? false,
                        $locale => [
                            'name' => $elm['name']
                        ]
                    ];
                } else {
                    $this->countries[$elm['id']][$locale]['name'] = $elm['name'];
                }
            }
        }
    }

     /**
     * @return void
     */
    protected function createCountry()
    {
        foreach ($this->countries as $elm)
        {
            $this->countryRepository->create($elm);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->mergeCountryTranslations();
        $this->createCountry();
    }
}
