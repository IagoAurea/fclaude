<?php

namespace Modules\Injury\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Test\Repositories\Interfaces\ResponseRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class ResponseTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var $responseRepository
     */
    protected $responseRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;
    
    /**
     * @var array
     */
    protected $responses = [];

    /**
     * ResponseTableSeeder constructor.
     */
    public function __construct(
        ResourceRepositoryInterface $resourceRepository,
        ResponseRepositoryInterface $responseRepository
        )
    {
        $this->responseRepository = $responseRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createResponses()
    {
        $filename = "injury-test-responses.json";

        $elements = $this->getDataJson($filename);

        foreach ($elements as $elm) {

            $responseCreate = [
                'es' => [
                    'name' => $elm['name_spanish'],
                    'tooltip' => isset($elm['tooltip_spanish']) ? $elm['tooltip_spanish'] : NULL,
                ],
                'en' => [
                    'name' => $elm['name_english'],
                    'tooltip' => isset($elm['tooltip_english']) ? $elm['tooltip_english']: NULL
                ],
                'code' => $elm['code'],
            ];

            if (isset($elm['color'])) {
                $responseCreate['color'] =  $elm['color'];
            }
            
            if (isset($elm['color_secondary'])) {
                $responseCreate['color_secondary'] =  $elm['color_secondary'];
            }

            if (isset($elm['image'])) {
                $params['directory'] = "test";
                $params['name'] = $elm['image'];
                $image = $this->getImage($params);
                $dataResource = $this->uploadResource('/injuries/tests/responses', $image);
                $resource = $this->resourceRepository->create($dataResource);

                $responseCreate['image_id'] =  $resource->id;
            }

            $this->responseRepository->create($responseCreate);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createResponses();
    }
}
