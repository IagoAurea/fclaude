<?php

namespace Modules\Alumn\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Alumn\Repositories\Interfaces\AcneaeSubtypeRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\AcneaeTypeRepositoryInterface;

class AcneaeTableSeeder extends Seeder
{
    /**
     * @var $acneaeTypeRepository
     */
    protected $acneaeTypeRepository;

    /**
     * @var $acneaeSubtypeRepository
     */
    protected $acneaeSubtypeRepository;

    /**
     * Create a new seeder instance
     */
    public function __construct(
        AcneaeTypeRepositoryInterface $acneaeTypeRepository,
        AcneaeSubtypeRepositoryInterface $acneaeSubtypeRepository,
    ) {
        $this->acneaeTypeRepository = $acneaeTypeRepository;
        $this->acneaeSubtypeRepository = $acneaeSubtypeRepository;
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'ACNEE',
                    'tooltip' => 'Alumno con necesidades educativas especiales'
                ],
                'en' => [
                    'name' => 'SEN',
                    'tooltip' => 'Special Education Needs',
                ],
                'code' => 'acnee',
                'subtypes' => [

                    [
                        'es' => [
                            'name' => 'Discapacidad física'
                        ],
                        'en' => [
                            'name' => 'Physical disability'
                        ],
                        'code' => 'physical_disability',
                    ],
                    [
                        'es' => [
                            'name' => 'Discapacidad psíquica'
                        ],
                        'en' => [
                            'name' => 'Mental disability'
                        ],
                        'code' => 'mental_disability'
                    ],
                    [
                        'es' => [
                            'name' => 'Discapacidad sensorial'
                        ],
                        'en' => [
                            'name' => 'Sensory disability'
                        ],
                        'code' => 'sensory_disability'
                    ],
                    [
                        'es' => [
                            'name' => 'Trastornos graves de conducta, del lenguaje y la comunicación'
                        ],
                        'en' => [
                            'name' => 'Serious behavior, language and communication disorders'
                        ],
                        'code' => 'serious_behavior'
                    ],
                ],
            ],
            [
                'es' => [
                    'name' => 'Retraso madurativo'
                ],
                'en' => [
                    'name' => 'Delayed maturation'
                ],
                'code' => 'delayed_maduration'
            ],
            [
                'es' => [
                    'name' => 'Trastornos del desarrollo del lenguaje y la comunicación '
                ],
                'en' => [
                    'name' => 'Language and communication development disorders'
                ],
                'code' => 'language_disorder'
            ],
            [
                'es' => [
                    'name' => 'Trastorno de atención o de aprendizaje'
                ],
                'en' => [
                    'name' => 'Attention or learning disorder'
                ],
                'code' => 'attention_or_learning_disorder',
                'subtypes' => [
                    [
                        'es' => [
                            'name' => 'Dificultades específicas del aprendizaje'
                        ],
                        'en' => [
                            'name' => 'Specific learning difficulties'
                        ],
                        'code' => 'specific_learning_difficulty'
                    ],
                    [
                        'es' => [
                            'name' => 'TDAH',
                            'tooltip' => 'Trastorno por déficit de atención e hiperactividad'
                        ],
                        'en' => [
                            'name' => 'ADHD',
                            'tooltip' => 'Attention Deficit / Hyperactivity Disorder'
                        ],
                        'code' => 'adhd'
                    ],
                ]
            ],
            [
                'es' => [
                    'name' => 'Desconocimiento grave de la lengua de aprendizaje '
                ],
                'en' => [
                    'name' => 'Serious lack of knowledge of the language of learning'
                ],
                'code' => 'serious_lack_of_knowledge'
            ],
            [
                'es' => [
                    'name' => 'Altas capacidades intelectuales'
                ],
                'en' => [
                    'name' => 'High intellectual abilities'
                ],
                'code' => 'high_intelectual_ability'
            ],
            [
                'es' => [
                    'name' => 'Incorporación tardía al sistema educativo'
                ],
                'en' => [
                    'name' => 'Late incorporation into the educational system'
                ],
                'code' => 'late_education'
            ],
            [
                'es' => [
                    'name' => 'Condiciones personales o de historia escolar'
                ],
                'en' => [
                    'name' => 'Personal conditions or school history'
                ],
                'code' => 'personal_condition'
            ],
        ];
    }

    /**
     * @return void
     */
    protected function createAcneaeType(array $elements)
    {
        foreach ($elements as $elm) {
            $payload = [
                'es' => $elm['es'],
                'en' => $elm['en'],
                'code' => $elm['code'],
            ];

            $acneae_type = $this->acneaeTypeRepository->create($payload);

            if (isset($elm['subtypes'])) {
                foreach ($elm['subtypes'] as $subtype) {
                    $subtype_payload = [
                        'acneae_type_id' => $acneae_type->id,
                        'es' => $subtype['es'],
                        'en' => $subtype['en'],
                        'code' => $subtype['code']
                    ];

                    $this->acneaeSubtypeRepository->create($subtype_payload);
                }
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAcneaeType($this->get()->current());
    }
}
