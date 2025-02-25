<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Generality\Repositories\Interfaces\WeatherRepositoryInterface;

class WeathersTableSeeder extends Seeder
{
    /**
     * repository
     * @var $weatherRepository
     */
    protected $weatherRepository;

    /**
     * WeathersTableSeeder constructor.
     * @param WeatherRepositoryInterface $weatherRepository
     */
    public function __construct(WeatherRepositoryInterface $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * Method create weathers
     * @param array $elements
     * @return void
     */
    protected function createWeathers(array $elements)
    {
        foreach ($elements as $element)
        {
            $this->weatherRepository->create($element);
        }
    }

    /**
     * @return \Generator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Soleado'
                ],
                'en' => [
                    'name' => 'Sunny'
                ],
                'code' => 'sunny'
            ],
            [
                'es' => [
                    'name' => 'Nublado'
                ],
                'en' => [
                    'name' => 'Cloudy'
                ],
                'code' => 'cloudy'
            ],
            [
                'es' => [
                    'name' => 'Lluvioso'
                ],
                'en' => [
                    'name' => 'Rainy'
                ],
                'code' => 'rainy'
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createWeathers($this->get()->current());
    }
}
