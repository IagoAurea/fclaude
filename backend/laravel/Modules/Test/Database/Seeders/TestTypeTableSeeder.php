<?php

namespace Modules\Test\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Test\Repositories\Interfaces\TestTypeRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Test\Entities\TestType;

class TestTypeTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $testTypeRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    public function __construct(
        TestTypeRepositoryInterface $testTypeRepository,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->testTypeRepository = $testTypeRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createTestType(array $elements)
    {
        foreach ($elements as $elm) {
            $params['directory'] = "test_type";
            $params['name'] = $elm['code'];
            $image = $this->getImage($params);

            $dataResource = $this->uploadResource('/tests/type', $image);

            $resource = $this->resourceRepository->create($dataResource);

            $elm['image_id'] =  $resource->id;

            $this->testTypeRepository->create($elm);
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
                    'name' => 'Antropométricos'
                ],
                'en' => [
                    'name' => 'Anthropometric'
                ],
                'code'  => 'anthropometric',
                'classification'  => TestType::CLASSIFICATION_TEST
            ],
            [
                'es' => [
                    'name' => 'Condición Física'
                ],
                'en' => [
                    'name' => 'Physical condition'
                ],
                'code'  => 'physical_condition',
                'classification'  => TestType::CLASSIFICATION_TEST
            ],
            [
                'es' => [
                    'name' => 'Habilidades Motrices'
                ],
                'en' => [
                    'name' => 'Motor skills'
                ],
                'code'  => 'motor_skills',
                'classification'  => TestType::CLASSIFICATION_TEST
            ],
            [
                'es' => [
                    'name' => 'Exploración Física'
                ],
                'en' => [
                    'name' => 'Physical exploration'
                ],
                'code'  => 'physical_exploration',
                'classification'  => TestType::CLASSIFICATION_TEST
            ],
            [
                'es' => [
                    'name' => 'Psicológicos'
                ],
                'en' => [
                    'name' => 'Psychological'
                ],
                'code'  => 'psychological_test',
                'classification'  => TestType::CLASSIFICATION_TEST
            ],
            [
                'es' => [
                    'name' => 'Funcionales'
                ],
                'en' => [
                    'name' => 'Functional'
                ],
                'code'           => 'functional',
                'classification'  => TestType::CLASSIFICATION_RFD
            ],
            [
                'es' => [
                    'name' => 'Psicológicos'
                ],
                'en' => [
                    'name' => 'Psychological'
                ],
                'code'  => 'psychological',
                'classification'  => TestType::CLASSIFICATION_BOTH
            ],
            [
                'es' => [
                    'name' => 'Recuperación Funcional Deportiva'
                ],
                'en' => [
                    'name' => 'Functional Sports Recovery'
                ],
                'code'  => 'rfd',
                'classification'  => TestType::CLASSIFICATION_RFD
            ],
            [
                'es' => [
                    'name' => 'Fisioterapia'
                ],
                'en' => [
                    'name' => 'Fisiotherapy'
                ],
                'code'  => 'fisiotherapy',
                'classification'  => TestType::CLASSIFICATION_FISIOTHERAPY
            ],
            [
                'es' => [
                    'name' => 'Sesiones de ejercicio'
                ],
                'en' => [
                    'name' => 'Exercise sessions'
                ],
                'code'  => 'exercise_session',
                'classification'  => TestType::CLASSIFICATION_EXERCISE_SESSION
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
        $this->createTestType($this->get()->current());
    }
}
