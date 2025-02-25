<?php

namespace Modules\Nutrition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Nutrition\Repositories\Interfaces\DietRepositoryInterface;

class DietsTableSeeder extends Seeder
{
   /**
     * @var object
     */
    protected $dietRepository;

    public function __construct(DietRepositoryInterface $dietRepository)
    {
        $this->dietRepository = $dietRepository;
    }

    /**
     * @return void
     */
    protected function createDiet(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->dietRepository->create($elm);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Alcalina'
                ],
                'en' => [
                    'name' => 'Alkaline'
                ],
                'code' => 'alkaline'
            ],
            [
                'es' => [
                    'name' => 'Ayuno intermitente'
                ],
                'en' => [
                    'name' => 'Intermittent fasting'
                ],
                'code' => 'intermittent_fasting'
            ],
            [
                'es' => [
                    'name' => 'Baja en carbohidratos'
                ],
                'en' => [
                    'name' => 'Low in carbohydrates (Lo-Carbs)'
                ],
                'code' => 'low_in_carbohydrates'
            ],
            [
                'es' => [
                    'name' => 'Detox'
                ],
                'en' => [
                    'name' => 'Detox'
                ],
                'code' => 'detox'
            ],
            [
                'es' => [
                    'name' => 'Hipercalórica'
                ],
                'en' => [
                    'name' => 'High-calorie (Hypercaloric)'
                ],
                'code' => 'hypercaloric'
            ],
            [
                'es' => [
                    'name' => 'Hipocalórica'
                ],
                'en' => [
                    'name' => 'Low-calorie (Hypocaloric)'
                ],
                'code' => 'hypocaloric'
            ],
            [
                'es' => [
                    'name' => 'Keto (cetogénica)'
                ],
                'en' => [
                    'name' => 'Keto (ketogenic)'
                ],
                'code' => 'keto'
            ],
            [
                'es' => [
                    'name' => 'Macrobiótica'
                ],
                'en' => [
                    'name' => 'Macrobiotic'
                ],
                'code' => 'macrobiotic'
            ],
            [
                'es' => [
                    'name' => 'Mediterránea'
                ],
                'en' => [
                    'name' => 'Mediterranean'
                ],
                'code' => 'mediterranean'
            ],
            [
                'es' => [
                    'name' => 'Montignac'
                ],
                'en' => [
                    'name' => 'Montignac'
                ],
                'code' => 'montignac'
            ],
            [
                'es' => [
                    'name' => 'Paleo'
                ],
                'en' => [
                    'name' => 'Paleo'
                ],
                'code' => 'paleo'
            ],
            [
                'es' => [
                    'name' => 'Proteica'
                ],
                'en' => [
                    'name' => 'Protein'
                ],
                'code' => 'protein'
            ],
            [
                'es' => [
                    'name' => 'Sin azucar'
                ],
                'en' => [
                    'name' => 'Sugar-free'
                ],
                'code' => 'sugarfree'
            ],
            [
                'es' => [
                    'name' => 'Vegana'
                ],
                'en' => [
                    'name' => 'Vegan'
                ],
                'code' => 'vegan'
            ],
            [
                'es' => [
                    'name' => 'Vegetariana'
                ],
                'en' => [
                    'name' => 'Vegetarian'
                ],
                'code' => 'vegetarian'
            ],
            [
                'es' => [
                    'name' => 'Otros (especificar)'
                ],
                'en' => [
                    'name' => 'Others (specify)'
                ],
                'code' => 'other'
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
        $this->createDiet($this->get()->current());
    }
}
