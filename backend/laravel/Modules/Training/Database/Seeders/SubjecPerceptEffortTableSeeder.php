<?php

namespace Modules\Training\Database\Seeders;

use App\Traits\ResourceTrait;
use App\Services\BaseSeeder;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Training\Repositories\Interfaces\SubjectivePerceptionEffortRepositoryInterface;

class SubjecPerceptEffortTableSeeder extends BaseSeeder
{
    use ResourceTrait;

   /**
     * @var object
     */
    protected $subjectivePerceptionEffortRepository;

    /**
    * @var $resourceRepository
    */
   protected $resourceRepository;

    public function __construct(
        SubjectivePerceptionEffortRepositoryInterface $subjectivePerceptionEffortRepository,
        ResourceRepositoryInterface $resourceRepository
    )
    {
        $this->subjectivePerceptionEffortRepository = $subjectivePerceptionEffortRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createSubjectivePerceptionEffort(array $elements)
    {
        foreach($elements as $elm)
        {
            $data_image = [
                'directory' => 'perception_efforts',
                'name' => $elm['code']
            ];

            $image = $this->getImage($data_image);

            $resource = $this->createResource($image);

            $elm['image_id'] = $resource->id;

            $this->subjectivePerceptionEffortRepository->create($elm);
        }
    }

    /**
    * @param $image
    * @return object
    */
    protected function createResource($image)
    {
      $data_resource = $this->uploadResource('/clubs/teams/perception_efforts', $image);

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
                    'name' => 'Reposo'
                ],
                'en' => [
                    'name' => 'Sleep'
                ],
                'code' => 'sleep',
                'number' => 0,
            ],
            [
                'es' => [
                    'name' => 'Muy muy ligero'
                ],
                'en' => [
                    'name' => 'Very very Light'
                ],
                'code' => 'very_very_light',
                'number' => 1,
            ],
            [
                'es' => [
                    'name' => 'Muy ligero'
                ],
                'en' => [
                    'name' => 'Very light'
                ],
                'code' => 'very_Light',
                'number' => 2,
            ],
            [
                'es' => [
                    'name' => 'Ligero'
                ],
                'en' => [
                    'name' => 'Light'
                ],
                'code' => 'light',
                'number' => 3,
            ],
            [
                'es' => [
                    'name' => 'Moderado'
                ],
                'en' => [
                    'name' => 'Moderate'
                ],
                'code' => 'moderate',
                'number' => 4,
            ],
            [
                'es' => [
                    'name' => 'Algo duro'
                ],
                'en' => [
                    'name' => 'Something hard'
                ],
                'code' => 'something_hard',
                'number' => 5,
            ],
            [
                'es' => [
                    'name' => 'Duro'
                ],
                'en' => [
                    'name' => 'Hard'
                ],
                'code' => 'hard',
                'number' => 6,
            ],
            [
                'es' => [
                    'name' => 'Muy duro'
                ],
                'en' => [
                    'name' => 'Very hard'
                ],
                'code' => 'very_hard',
                'number' => 7,
            ],
            [
                'es' => [
                    'name' => 'Muy muy duro'
                ],
                'en' => [
                    'name' => 'Very very Hard'
                ],
                'code' => 'very_very_hard',
                'number' => 8,
            ],
            [
                'es' => [
                    'name' => 'Máximo'
                ],
                'en' => [
                    'name' => 'Maximum'
                ],
                'code' => 'maximum',
                'number' => 9,
            ],
            [
                'es' => [
                    'name' => 'Extremo'
                ],
                'en' => [
                    'name' => 'Extreme'
                ],
                'code' => 'extreme',
                'number' => 10,
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
        $this->createSubjectivePerceptionEffort($this->get()->current());
    }
}
