<?php

namespace Modules\Exercise\Database\Seeders;

use App\Traits\ResourceTrait;
use App\Services\BaseSeeder;
use Modules\Exercise\Repositories\Interfaces\ContentExerciseRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class ContentsExerciseTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $contentRepository;

    /**
    * @var $resourceRepository
    */
   protected $resourceRepository;

    public function __construct(ContentExerciseRepositoryInterface $contentRepository, ResourceRepositoryInterface $resourceRepository)
    {
        $this->contentRepository = $contentRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createContentExercise(array $elements)
    {
        foreach($elements as $elm)
        {
            $data_image = [
              'directory' => 'content_exercises',
              'name' => $elm['code']
            ];

            $image = $this->getImage($data_image);

            $resource = $this->createResource($image);

            $elm['image_id'] = $resource->id;

            $this->contentRepository->create($elm);
        }
    }

    /**
    * @param $image
    * @return object
    */
    protected function createResource($image)
    {
      $data_resource = $this->uploadResource('/clubs/teams/content_exercises', $image);

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
                    'name' => 'Técnica'
                ],
                'en' => [
                    'name' => 'Technique'
                ],
                'code' => 'technicians'
            ],
            [
                'es' => [
                    'name' => 'Táctica'
                ],
                'en' => [
                    'name' => 'Tactic'
                ],
                'code' => 'tactical'
            ],
            [
                'es' => [
                    'name' => 'Preparación física'
                ],
                'en' => [
                    'name' => 'Physical training'
                ],
                'code' => 'physical_preparation'
            ],
            [
                'es' => [
                    'name' => 'Psico-sociales'
                ],
                'en' => [
                    'name' => 'Psychosocial'
                ],
                'code' => 'psychosocial'
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
        $this->createContentExercise($this->get()->current());
    }
}
