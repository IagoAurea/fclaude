<?php

namespace Modules\EffortRecovery\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerTypeRepositoryInterface;

class WellnessQuestionnaireAnswerTypeTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $answerTypeRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        WellnessQuestionnaireAnswerTypeRepositoryInterface $answerTypeRepository,
        ResourceRepositoryInterface $resourceRepository
    )
    {
        $this->answerTypeRepository = $answerTypeRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createAnswerType(array $elements)
    {
        foreach($elements as $elm)
        {
            if (isset($elm['image'])) {
                $params['directory'] = "test";

                $params['name'] = $elm['image'];
                
                $image = $this->getImage($params);
                
                $dataResource = $this->uploadResource('/efforts-recovery', $image);
                
                $resource = $this->resourceRepository->create($dataResource);

                $elm['image_id'] =  $resource->id;

                unset($elm['image']);
            }

            $this->answerTypeRepository->create($elm);
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
                    'name' => 'Sueño'
                ],
                'en' => [
                    'name' => 'Dream'
                ],
                'code' => 'dream',
                'image' => 'dream',
            ],
            [
                'es' => [
                    'name' => 'Estrés'
                ],
                'en' => [
                    'name' => 'Stress'
                ],
                'code' => 'stress',
                'image' => 'stress',
            ],
            [
                'es' => [
                    'name' => 'Fatiga'
                ],
                'en' => [
                    'name' => 'Fatigue'
                ],
                'code' => 'fatigue',
                'image' => 'fatigue',
            ],
            [
                'es' => [
                    'name' => 'Dolor Muscular (DOMS)'
                ],
                'en' => [
                    'name' => 'Muscle Pain'
                ],
                'code' => 'muscle_pain',
                'image' => 'muscle_pain',
            ],
            [
                'es' => [
                    'name' => 'Estado de Ánimo'
                ],
                'en' => [
                    'name' => 'Mood'
                ],
                'code' => 'mood',
                'image' => 'mood',
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
        $this->createAnswerType($this->get()->current());
    }
}
