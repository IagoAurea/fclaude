<?php

namespace Modules\Test\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Test\Services\TestService;
use Modules\Generality\Services\ResourceService;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestTypeRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestSubTypeRepositoryInterface;
use Modules\Test\Repositories\Interfaces\ConfigurationRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class TestTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $testService
     */
    protected $testService;

    /**
     * @var object
     */
    protected $testTypeRepository;

    /**
     * @var object
     */
    protected $testSubTypeRepository;

    /**
     * @var object
     */
    protected $configRepository;
    
    /**
     * @var object
     */
    protected $sportRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        TestRepositoryInterface $testRepository,
        ResourceRepositoryInterface $resourceRepository,
        ResourceService $resourceService,
        TestService $testService,
        TestTypeRepositoryInterface $testTypeRepository,
        TestSubTypeRepositoryInterface $testSubTypeRepository,
        ConfigurationRepositoryInterface $configRepository,
        SportRepositoryInterface $sportRepository
    ) {
        $this->testRepository = $testRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
        $this->testService = $testService;
        $this->testTypeRepository = $testTypeRepository;
        $this->testSubTypeRepository = $testSubTypeRepository;
        $this->configRepository = $configRepository;
        $this->sportRepository = $sportRepository;
    }

    /**
     * @return void
     */
    protected function createTest()
    {
        $filenames = [
            "anthropometric", "motor_skills_jump", "motor_skills_coordination", "motor_skills_balance",
            "physical_condition_strength", "physical_condition_flexibility", "physical_condition_agility",
            "physical_condition_endurance", "physical_condition_speed", "physical_exploration_shoulder",            
            "physical_exploration_elbow", "physical_exploration_column", "physical_exploration_hips",
            "physical_exploration_thigh", "physical_exploration_knee", "physical_exploration_calf",
            "physical_exploration_ankle", "psychological"
        ];

        foreach( $filenames as $filename ) {
            $elements = $this->getDataJson("tests/" . $filename . ".json");

            $test_type_id = null;
            $test_sub_type_id = null;
            $sport_id = null;
    
            foreach ($elements as $elm) {
                $configurations = [];
    
                $params['directory'] = 'test';
                $params['name'] = $elm['code'];
                $image = $this->getImage($params);
    
                $dataResource = $this->uploadResource('/tests', $image);
                $resource = $this->resourceRepository->create($dataResource);
                $test_type = $this->testTypeRepository->findOneBy(["code" => $elm['test_type_code']]);
                $test_type_id = $test_type->id;
    
                if ($elm['test_sub_type_code'] != null) {
                    $test_sub_type = $this->testSubTypeRepository->findOneBy(["code" => $elm['test_sub_type_code']]);
                    $test_sub_type_id =  $test_sub_type->id;
                }
    
                if ($elm['sport_code'] != null) {
                    $sport = $this->sportRepository->findOneBy(["code" => $elm['sport_code']]);
                    $sport_id =  $sport->id;
                }
    
                $testCreate = [
                    'es' => [
                        'name' => $elm['name_spanish'],
                        'description' => $elm['description_spanish'],
                        'instruction' => isset($elm['instruction_spanish']) ? $elm['instruction_spanish'] : '',
                        'material' => isset($elm['material_spanish']) ? $elm['material_spanish'] : '',
                        'procedure' => isset($elm['procedure_spanish']) ? $elm['procedure_spanish'] : '',
                        'evaluation' => isset($elm['evaluation_spanish']) ? $elm['evaluation_spanish'] : '',
                        'tooltip' => isset($elm['tooltip_spanish']) ?? NULL
                    ],
                    'en' => [
                        'name' => $elm['name_english'],
                        'description' => $elm['description_english'],
                        'instruction' => isset($elm['instruction_english']) ? $elm['instruction_english'] : '',
                        'material' => isset($elm['material_english']) ? $elm['material_english'] : '',
                        'procedure' => isset($elm['procedure_english']) ? $elm['procedure_english'] : '',
                        'evaluation' => isset($elm['evaluation_english']) ? $elm['evaluation_english'] : '',
                        'tooltip' => isset($elm['tooltip_english']) ?? NULL
                    ],
                    'test_type_id' => $test_type_id,
                    'test_sub_type_id' => $test_sub_type_id,
                    'type_valoration_code' => $elm['type_valoration_code'],
                    'value' => $elm['value'],
                    'value' => $elm['value'],
                    'sport_id' => $sport_id,
                    'code' => $elm['code'],
                    'image_id' => $resource->id,
                    'inverse' => isset($elm['inverse']) ?? FALSE
                ];
    
                $test = $this->testRepository->create($testCreate);
    
                $this->testService->createQuestions(json_encode($elm['associate_questions']), $test->id);
    
                if ($elm['configurations']) {
                    foreach ($elm['configurations'] as $configuration) {
                        $config = $this->configRepository->findOneBy([
                            'code' => $configuration
                        ]);
    
                        if ($config) {
                            array_push($configurations, $config->id);
                        }
                    }
    
                    $configurations = $this->testService->createConfigurations(json_encode($configurations), $test->id);
                }
    
                if ($elm['table']) {
                    $this->testService->createTable(json_encode($elm['table']), $test->id);
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
        $this->createTest();
    }
}
