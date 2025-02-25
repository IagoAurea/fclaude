<?php

namespace Modules\Test\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Test\Repositories\Interfaces\TestSubTypeRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestTypeRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class TestSubTypeTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $testSubTypeRepository;

    /**
     * @var object
     */
    protected $testTypeRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    public function __construct(
        TestSubTypeRepositoryInterface $testSubTypeRepository,
        TestTypeRepositoryInterface $testTypeRepository,
        ResourceRepositoryInterface $resourceRepository

    )
    {
        $this->testSubTypeRepository = $testSubTypeRepository;
        $this->testTypeRepository = $testTypeRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createTestSubType()
    {
        $test_types = $this->testTypeRepository->findAll();

        foreach ($test_types as $test_type) {

            $test_sub_types = $this->getTestSubType($test_type->code);

            foreach ($test_sub_types as $test_sub_type) {

                $params['directory']= "test_subtype";
                $params['name']= $test_sub_type['code'];
                $image = $this->getImage($params);
    
                $dataResource = $this->uploadResource('/injuries/subtype', $image);
    
                $resource = $this->resourceRepository->create($dataResource);

                $test_sub_type['image_id'] =  $resource->id;

                $test_sub_type['test_type_id'] = $test_type->id;
                $this->testSubTypeRepository->create($test_sub_type);
            }
        }
    }

    /**
     * @return \Iterator
     */
    private function getTestSubType($code)
    {
        $test_sub_types = [
            
            'physical_condition' => [
                [
                    'es' => [
                        'name' => 'Fuerza'
                    ],
                    'en' => [
                        'name' => 'Strength'
                    ],
                    'code' => 'strength'
                ],
                [
                    'es' => [
                        'name' => 'Flexibilidad'
                    ],
                    'en' => [
                        'name' => 'Flexibility'
                    ],
                    'code' => 'flexibility'
                ],
                [
                    'es' => [
                        'name' => 'Resistencia'
                    ],
                    'en' => [
                        'name' => 'Endurance'
                    ],
                    'code' => 'endurance'
                ],
                [
                    'es' => [
                        'name' => 'Velocidad'
                    ],
                    'en' => [
                        'name' => 'Speed'
                    ],
                    'code' => 'speed'
                ],
                [
                    'es' => [
                        'name' => 'Agilidad'
                    ],
                    'en' => [
                        'name' => 'Agility'
                    ],
                    'code' => 'agility'
                ],
            ],
            'motor_skills' => [
                [
                    'es' => [
                        'name' => 'Coordinación'
                    ],
                    'en' => [
                        'name' => 'Coordination'
                    ],
                    'code' => 'coordination'
                ],
                [
                    'es' => [
                        'name' => 'Equilibrio'
                    ],
                    'en' => [
                        'name' => 'Balance'
                    ],
                    'code' => 'balance'
                ],
                [
                    'es' => [
                        'name' => 'Salto'
                    ],
                    'en' => [
                        'name' => 'Jump'
                    ],
                    'code' => 'jump'
                ]
            ],
            'physical_exploration' => [
                [
                    'es' => [
                        'name' => 'Hombro'
                    ],
                    'en' => [
                        'name' => 'Shoulder'
                    ],
                    'code' => 'shoulder'
                ],
                [
                    'es' => [
                        'name' => 'Codo'
                    ],
                    'en' => [
                        'name' => 'Elbow'
                    ],
                    'code' => 'elbow'
                ],
                [
                    'es' => [
                        'name' => 'Columna'
                    ],
                    'en' => [
                        'name' => 'Column'
                    ],
                    'code' => 'column'
                ],
                [
                    'es' => [
                        'name' => 'Cadera'
                    ],
                    'en' => [
                        'name' => 'Hips'
                    ],
                    'code' => 'hips'
                ],
                [
                    'es' => [
                        'name' => 'Muslo'
                    ],
                    'en' => [
                        'name' => 'Thigh'
                    ],
                    'code' => 'thigh'
                ],
                [
                    'es' => [
                        'name' => 'Pantorrilla'
                    ],
                    'en' => [
                        'name' => 'Calf'
                    ],
                    'code' => 'calf'
                ],
                [
                    'es' => [
                        'name' => 'Rodilla'
                    ],
                    'en' => [
                        'name' => 'Knee'
                    ],
                    'code' => 'knee'
                ],
                [
                    'es' => [
                        'name' => 'Tobillo'
                    ],
                    'en' => [
                        'name' => 'Ankle'
                    ],
                    'code' => 'ankle'
                ],
            ],
            'anthropometric' => [],
            'functional' => [],
            'psychological' => [],
            'psychological_test' => [],
            'rfd' => [],
            'fisiotherapy' => [],
            'exercise_session' => [
                [
                    'es' => [
                        'name' => 'FC - Frecuencia cardiaca'
                    ],
                    'en' => [
                        'name' => 'FC - Heart rate'
                    ],
                    'code'           => 'heart_rate'
                ],
                [
                    'es' => [
                        'name' => 'GPS'
                    ],
                    'en' => [
                        'name' => 'GPS'
                    ],
                    'code'           => 'gps'
                ],
            ]
            
        ];

        return $test_sub_types[$code];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTestSubType();
    }
}
