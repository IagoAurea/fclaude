<?php

namespace Modules\AlumnControl\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlItemRepositoryInterface;

class DailyControlItemTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var $dailyControlItemRepository
     */
    protected $dailyControlItemRepository;
    
    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    public function __construct(
        DailyControlItemRepositoryInterface $dailyControlItemRepository,
        ResourceRepositoryInterface $resourceRepository
    )
    {
        $this->dailyControlItemRepository = $dailyControlItemRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createDailyControlItem(array $elements)
    {
        foreach($elements as $elm)
        {
            $data_image = [
                'directory' => 'daily_controls',
                'name' => $elm['code']
            ];
  
            $image = $this->getImage($data_image);

            $resource = $this->createResource($image);

            $elm['image_id'] = $resource->id;
            
            $this->dailyControlItemRepository->create($elm);
        }
    }

    /**
    * @param $image
    * @return object
    */
    protected function createResource($image)
    {
      $data_resource = $this->uploadResource('/teachers/daily-control-items', $image);

      return $this->resourceRepository->create($data_resource);
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'es' => [
                    'name' => 'Retraso'
                ],
                'en' => [
                    'name' => 'Delay'
                ],
                'code' => 'delay',
                'order' => 3
            ],
            [
                'es' => [
                    'name' => 'Anotación positiva'
                ],
                'en' => [
                    'name' => 'Positive note'
                ],
                'code' => 'positive_note',
                'order' => 8
            ],
            [
                'es' => [
                    'name' => 'Anotación negativa'
                ],
                'en' => [
                    'name' => 'Negative note'
                ],
                'code' => 'negative_note',
                'order' => 9
            ],
            [
                'es' => [
                    'name' => 'No higiene'
                ],
                'en' => [
                    'name' => 'Not hygiene'
                ],
                'code' => 'not_hygiene',
                'order' => 5
            ],

            [
                'es' => [
                    'name' => 'Falta justificada'
                ],
                'en' => [
                    'name' => 'Excused absence'
                ],
                'code' => 'excused_absence',
                'order' => 2
            ],
            [
                'es' => [
                    'name' => 'Falta'
                ],
                'en' => [
                    'name' => 'Absence'
                ],
                'code' => 'absence',
                'order' => 1
            ],
            [
                'es' => [
                    'name' => 'No cuida el material'
                ],
                'en' => [
                    'name' => "Doesn't take care"
                ],
                'code' => 'material_care',
                'order' => 10
            ],
            [
                'es' => [
                    'name' => 'No respeto'
                ],
                'en' => [
                    'name' => 'No respect'
                ],
                'code' => 'no_respect',
                'order' => 7
            ],
            [
                'es' => [
                    'name' => 'No esfuerzo'
                ],
                'en' => [
                    'name' => 'No effort'
                ],
                'code' => 'no_effort',
                'order' => 6
            ],
            [
                'es' => [
                    'name' => 'No ropa deportiva'
                ],
                'en' => [
                    'name' => 'No sport wear'
                ],
                'code' => 'no_sport_wear',
                'order' => 4
            ],
            [
                'es' => [
                    'name' => 'Lesion'
                ],
                'en' => [
                    'name' => "Injury"
                ],
                'code' => 'injury',
                'order' => 11
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
        $this->createDailyControlItem($this->get()->current());
    }
}
