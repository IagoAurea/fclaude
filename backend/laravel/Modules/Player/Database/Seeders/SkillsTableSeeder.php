<?php

namespace Modules\Player\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Player\Repositories\Interfaces\SkillsRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class SkillsTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $skillsRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(
        SkillsRepositoryInterface $skillsRepository,
        ResourceRepositoryInterface $resourceRepository
    )
    {
        $this->skillsRepository = $skillsRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createSkill(array $elements)
    {
        foreach($elements as $elm)
        {
            $params['directory']= "content_exercises";
            $params['name']= $elm['code'];
            $image = $this->getImage($params);

            $dataResource = $this->uploadResource('/players/skills', $image);

            $resource = $this->resourceRepository->create($dataResource);
            $elm['image_id'] =  $resource->id;
            $this->skillsRepository->create($elm);
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
                    'name' => 'Capacidades Físicas'
                ],
                'en' => [
                    'name' => 'Physical skills'
                ],
                'code' => 'physical_preparation',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Capacidades Técnicas'
                ],
                'en' => [
                    'name' => 'Technical skills'
                ],
                'code' => 'technicians',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Capacidades Tácticas'
                ],
                'en' => [
                    'name' => 'Tactical skills'
                ],
                'code' => 'tactical',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Capacidades Psicológicas'
                ],
                'en' => [
                    'name' => 'Psychological skills'
                ],
                'code' => 'psychosocial',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Capacidades Sociales'
                ],
                'en' => [
                    'name' => 'Social skills'
                ],
                'code' => 'social',
                'image_id' => ''
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
        $this->createSkill($this->get()->current());
    }
}
