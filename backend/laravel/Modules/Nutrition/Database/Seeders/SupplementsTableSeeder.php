<?php

namespace Modules\Nutrition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Nutrition\Repositories\Interfaces\SupplementRepositoryInterface;

class SupplementsTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $supplementRepository;

    public function __construct(SupplementRepositoryInterface $supplementRepository)
    {
        $this->supplementRepository = $supplementRepository;
    }

    /**
     * @return void
     */
    protected function createSupplement(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->supplementRepository->create($elm);
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
                    'name' => 'Ácido hialurónico'
                ],
                'en' => [
                    'name' => 'Hyaluronic acid'
                ],
                'code' => 'hyaluronic_acid'
            ],
            [
                'es' => [
                    'name' => 'Aminoácidos ramificados (BCAAs)'
                ],
                'en' => [
                    'name' => 'Branched-chain amino acids (BCAAs)'
                ],
                'code' => 'branched_chain_amino_acids'
            ],
            [
                'es' => [
                    'name' => 'Arginina'
                ],
                'en' => [
                    'name' => 'Arginine'
                ],
                'code' => 'arginine'
            ],
            [
                'es' => [
                    'name' => 'Beta-Hidroxi-Beta-Metilbutirato (HMB)'
                ],
                'en' => [
                    'name' => 'β-Hydroxy β-methylbutyric acid (HMB)'
                ],
                'code' => 'beta_hydroxy_beta_methylbutyrate'
            ],
            [
                'es' => [
                    'name' => 'Bicarbonato'
                ],
                'en' => [
                    'name' => 'Bicarbonate'
                ],
                'code' => 'baking_soda'
            ],
            [
                'es' => [
                    'name' => 'Cafeína'
                ],
                'en' => [
                    'name' => 'Caffeine'
                ],
                'code' => 'caffeine'
            ],
            [
                'es' => [
                    'name' => 'Calcio'
                ],
                'en' => [
                    'name' => 'Calcium'
                ],
                'code' => 'calcium'
            ],
            [
                'es' => [
                    'name' => 'Carbohidratos'
                ],
                'en' => [
                    'name' => 'Carbohydrates'
                ],
                'code' => 'carbohydrates'
            ],
            [
                'es' => [
                    'name' => 'Carnitina'
                ],
                'en' => [
                    'name' => 'Carnitine'
                ],
                'code' => 'carnitine'
            ],
            [
                'es' => [
                    'name' => 'Coenzima Q10'
                ],
                'en' => [
                    'name' => 'Coenzyme Q10'
                ],
                'code' => 'coenzyme_q10'
            ],
            [
                'es' => [
                    'name' => 'Colágeno'
                ],
                'en' => [
                    'name' => 'Collagen'
                ],
                'code' => 'collagen'
            ],
            [
                'es' => [
                    'name' => 'Condroitina'
                ],
                'en' => [
                    'name' => 'Chondroitin'
                ],
                'code' => 'chondroitin'
            ],
            [
                'es' => [
                    'name' => 'Creatina'
                ],
                'en' => [
                    'name' => 'Creatine'
                ],
                'code' => 'creatine'
            ],
            [
                'es' => [
                    'name' => 'Electrolitos'
                ],
                'en' => [
                    'name' => 'Electrolytes'
                ],
                'code' => 'electrolytes'
            ],
            [
                'es' => [
                    'name' => 'Glucosamina'
                ],
                'en' => [
                    'name' => 'Glucosamine'
                ],
                'code' => 'glucosamine'
            ],
            [
                'es' => [
                    'name' => 'Glutamina'
                ],
                'en' => [
                    'name' => 'Glutamine'
                ],
                'code' => 'glutamine'
            ],
            [
                'es' => [
                    'name' => 'Hierro'
                ],
                'en' => [
                    'name' => 'Iron'
                ],
                'code' => 'iron'
            ],
            [
                'es' => [
                    'name' => 'Magnesio'
                ],
                'en' => [
                    'name' => 'Magnesium'
                ],
                'code' => 'magnesium'
            ],
            [
                'es' => [
                    'name' => 'Multivitamínicos'
                ],
                'en' => [
                    'name' => 'Multivitamins'
                ],
                'code' => 'multivitamins'
            ],
            [
                'es' => [
                    'name' => 'Pre-entrenos'
                ],
                'en' => [
                    'name' => 'Pre-workouts'
                ],
                'code' => 'pre_training'
            ],
            [
                'es' => [
                    'name' => 'Probióticos'
                ],
                'en' => [
                    'name' => 'Probiotics'
                ],
                'code' => 'probiotics'
            ],
            [
                'es' => [
                    'name' => 'Proteínas'
                ],
                'en' => [
                    'name' => 'Proteins'
                ],
                'code' => 'protein'
            ],
            [
                'es' => [
                    'name' => 'Quemagrasas'
                ],
                'en' => [
                    'name' => 'Fat burners'
                ],
                'code' => 'fat_burn'
            ],
            [
                'es' => [
                    'name' => 'Vitamina C'
                ],
                'en' => [
                    'name' => 'Vitamin C'
                ],
                'code' => 'vitamin_c'
            ],
            [
                'es' => [
                    'name' => 'Vitamina D'
                ],
                'en' => [
                    'name' => 'Vitamin D'
                ],
                'code' => 'vitamin_d'
            ],
            [
                'es' => [
                    'name' => 'Zinc'
                ],
                'en' => [
                    'name' => 'Zinc'
                ],
                'code' => 'zinc'
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
        $this->createSupplement($this->get()->current());
    }

}



