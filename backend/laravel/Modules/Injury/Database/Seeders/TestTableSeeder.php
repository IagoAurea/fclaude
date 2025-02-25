<?php

namespace Modules\Injury\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Test\Services\TestService;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestTypeRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestSubTypeRepositoryInterface;
use Modules\Test\Repositories\Interfaces\ConfigurationRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;

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


    public function __construct(
        TestRepositoryInterface $testRepository,
        ResourceRepositoryInterface $resourceRepository,
        TestService $testService,
        TestTypeRepositoryInterface $testTypeRepository,
        TestSubTypeRepositoryInterface $testSubTypeRepository,
        ConfigurationRepositoryInterface $configRepository,
        SportRepositoryInterface $sportRepository
    ) {
        $this->testRepository = $testRepository;
        $this->resourceRepository = $resourceRepository;
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
        $filename = "injury-test.json";
        $elements = $this->getDataJson($filename);
        $test_type_id = null;
        $test_sub_type_id = null;
        $sport_id = null;


        foreach ($elements as $elm) {

            $configurations = [];

            $params['directory'] = "test";
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
                    'name' => $elm['name_spanish']
                ],
                'en' => [
                    'name' => $elm['name_english']
                ],
                'test_type_id' => $test_type_id,
                'test_sub_type_id' => $test_sub_type_id,
                'type_valoration_code' => $elm['type_valoration_code'],
                'value' => $elm['value'],
                'sport_id' => $sport_id,
                'code' => $elm['code'],
                'image_id' => $resource->id
            ];

            $test = $this->testRepository->create($testCreate);
            
            $this->testService->createQuestions(json_encode($elm['associate_questions']), $test->id);

            if ($elm['configurations']) {
                foreach ($elm['configurations'] as $configuration) {
                    $config =  $this->configRepository->findOneBy(["code" => $configuration]);

                    array_push($configurations, $config->id);
                }
                $configurations = $this->testService->createConfigurations(json_encode($configurations), $test->id);
            }
            if ($elm['table']) {
                $this->testService->createTable(json_encode($elm['table']), $test->id);
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
