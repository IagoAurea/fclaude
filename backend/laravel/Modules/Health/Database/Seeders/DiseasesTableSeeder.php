<?php

namespace Modules\Health\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Health\Repositories\Interfaces\DiseaseRepositoryInterface;

class DiseasesTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $diseaseRepository;

    public function __construct(DiseaseRepositoryInterface $diseaseRepository)
    {
        $this->diseaseRepository = $diseaseRepository;
    }

    /**
     * @return void
     */
    protected function createDisease(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->diseaseRepository->create($elm);
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
                    'name' => 'Aparato Digestivo'
                ],
                'en' => [
                    'name' => 'Digestive Aparatus'
                ],
                'code' => 'digestive_aparatus'
            ],
            [
                'es' => [
                    'name' => 'Aparato Respiratorio'
                ],
                'en' => [
                    'name' => 'Respiratory Tract'
                ],
                'code' => 'respiratory_tract'
            ],
            [
                'es' => [
                    'name' => 'Aparato visual'
                ],
                'en' => [
                    'name' => 'Visual apparatus'
                ],
                'code' => 'visual_apparatus'
            ],
            [
                'es' => [
                    'name' => 'Embarazo, parto y puerperio'
                ],
                'en' => [
                    'name' => 'Pregnancy, childbirth and puerperium'
                ],
                'code' => 'pregnancy_childbirth'
            ],
            [
                'es' => [
                    'name' => 'Endocrinas, nutricionales y metabólicas'
                ],
                'en' => [
                    'name' => 'Endocrine, nutritional and metabolic'
                ],
                'code' => 'endocrine_nutritional'
            ],
            [
                'es' => [
                    'name' => 'Infecciosas y parasitarias'
                ],
                'en' => [
                    'name' => 'Infectious and parasitic'
                ],
                'code' => 'infectious_parasitic'
            ],
            [
                'es' => [
                    'name' => 'Malformaciones'
                ],
                'en' => [
                    'name' => 'Malformations'
                ],
                'code' => 'malformations'
            ],
            [
                'es' => [
                    'name' => 'Mioplasias'
                ],
                'en' => [
                    'name' => 'Myoplasias'
                ],
                'code' => 'myoplasias'
            ],
            [
                'es' => [
                    'name' => 'Oido'
                ],
                'en' => [
                    'name' => 'Hearing'
                ],
                'code' => 'hearing'
            ],
            [
                'es' => [
                    'name' => 'Piel'
                ],
                'en' => [
                    'name' => 'Skin'
                ],
                'code' => 'skin'
            ],
            [
                'es' => [
                    'name' => 'Trastornos del ciclo del sueño y vigilia'
                ],
                'en' => [
                    'name' => 'Sleep wake cycle disorders'
                ],
                'code' => 'sleep_wake_cycle'
            ],
            [
                'es' => [
                    'name' => 'Trastornos mentales y del comportamiento'
                ],
                'en' => [
                    'name' => 'Mental and behavioral disorders'
                ],
                'code' => 'mental_behavioral_disorders'
            ],
            [
                'es' => [
                    'name' => 'Sangre'
                ],
                'en' => [
                    'name' => 'Blood'
                ],
                'code' => 'blood'
            ],
            [
                'es' => [
                    'name' => 'Sistema Circulatorio'
                ],
                'en' => [
                    'name' => 'Circulatory System'
                ],
                'code' => 'circulatory_system'
            ],
            [
                'es' => [
                    'name' => 'Sistema genitourinario'
                ],
                'en' => [
                    'name' => 'Genitourinary system'
                ],
                'code' => 'genitourinary_system'
            ],
            [
                'es' => [
                    'name' => 'Sistema inmune'
                ],
                'en' => [
                    'name' => 'Immune system'
                ],
                'code' => 'immune_system'
            ],
            [
                'es' => [
                    'name' => 'Sistema musculoesquelético'
                ],
                'en' => [
                    'name' => 'Musculoskeletal system'
                ],
                'code' => 'musculoskeletal_system'
            ],
            [
                'es' => [
                    'name' => 'Sistema Nervioso'
                ],
                'en' => [
                    'name' => 'Nervous System'
                ],
                'code' => 'nervous_system'
            ],
            [
                'es' => [
                    'name' => 'Otras'
                ],
                'en' => [
                    'name' => 'Other'
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
        $this->createDisease($this->get()->current());
    }
}
