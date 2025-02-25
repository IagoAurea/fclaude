<?php

namespace Modules\EffortRecovery\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerTypeRepositoryInterface;
use Modules\EffortRecovery\Repositories\Interfaces\WellnessQuestionnaireAnswerItemRepositoryInterface;

class WellnessQuestionnaireAnswerItemTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $answerTypeRepository;

    /**
     * @var object
     */
    protected $answerItemRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(
        WellnessQuestionnaireAnswerTypeRepositoryInterface $answerTypeRepository,
        WellnessQuestionnaireAnswerItemRepositoryInterface $answerItemRepository,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->answerTypeRepository = $answerTypeRepository;
        $this->answerItemRepository = $answerItemRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createAnswerItems()
    {
        $types = $this->answerTypeRepository->findAll();

        foreach ($types as $type) {
            $typeItems = $this->getTypeSet($type->code);

            foreach ($typeItems as $item) {
                $item['wellness_questionnaire_answer_type_id'] = $type->id;

                if (isset($item['image'])) {
                    $params['directory'] = "test";
    
                    $params['name'] = $item['image'];
                    
                    $image = $this->getImage($params);
                    
                    $dataResource = $this->uploadResource('/efforts-recovery', $image);
                    
                    $resource = $this->resourceRepository->create($dataResource);
    
                    $item['image_id'] =  $resource->id;
    
                    unset($item['image']);
                }
                
                $this->answerItemRepository->create($item);
            }
        }
    }

    /**
     * @return \Iterator
     */
    private function getTypeSet($key)
    {
        $values = [
            'dream' => [
                [
                    'es' => [
                        'name' => 'Insomnio'
                    ],
                    'en' => [
                        'name' => 'Insomnia'
                    ],
                    'code' => 'insomnia',
                    'image' => 'face_very_bad',
                    'charge' => 1,
                ],
                [
                    'es' => [
                        'name' => 'Sueño inquieto'
                    ],
                    'en' => [
                        'name' => 'Restless sleep'
                    ],
                    'code' => 'restless_sleep',
                    'image' => 'face_bad',
                    'charge' => 2,
                ],
                [
                    'es' => [
                        'name' => 'Dificultad para conciliar el sueño'
                    ],
                    'en' => [
                        'name' => 'Difficulty getting to sleep'
                    ],
                    'code' => 'difficulty',
                    'image' => 'face_regular',
                    'charge' => 3,
                ],
                [
                    'es' => [
                        'name' => 'Bueno'
                    ],
                    'en' => [
                        'name' => 'Good'
                    ],
                    'code' => 'good',
                    'image' => 'face_good',
                    'charge' => 4,
                ],
                [
                    'es' => [
                        'name' => 'Muy relajante'
                    ],
                    'en' => [
                        'name' => 'Very relaxing'
                    ],
                    'code' => 'very_relaxing',
                    'image' => 'face_very_good',
                    'charge' => 5,
                ],
            ],
            'stress' => [
                [
                    'es' => [
                        'name' => 'Muy estresado'
                    ],
                    'en' => [
                        'name' => 'Very stressed'
                    ],
                    'code' => 'very_stressed',
                    'image' => 'face_very_bad',
                    'charge' => 1,
                ],
                [
                    'es' => [
                        'name' => 'Estresado'
                    ],
                    'en' => [
                        'name' => 'Stressed'
                    ],
                    'code' => 'stressed',
                    'image' => 'face_bad',
                    'charge' => 2,
                ],
                [
                    'es' => [
                        'name' => 'Normal'
                    ],
                    'en' => [
                        'name' => 'Normal'
                    ],
                    'code' => 'normal',
                    'image' => 'face_regular',
                    'charge' => 3,
                ],
                [
                    'es' => [
                        'name' => 'Relajado'
                    ],
                    'en' => [
                        'name' => 'Relaxed'
                    ],
                    'code' => 'relaxed',
                    'image' => 'face_good',
                    'charge' => 4,
                ],
                [
                    'es' => [
                        'name' => 'Muy relajado'
                    ],
                    'en' => [
                        'name' => 'Very relaxed'
                    ],
                    'code' => 'very_relaxed',
                    'image' => 'face_very_good',
                    'charge' => 5,
                ],
            ],
            'fatigue' => [
                [
                    'es' => [
                        'name' => 'Muy fatigado'
                    ],
                    'en' => [
                        'name' => 'Very fatigued'
                    ],
                    'code' => 'very_fatigued',
                    'image' => 'face_very_bad',
                    'charge' => 1,
                ],
                [
                    'es' => [
                        'name' => 'Más fatigado de lo normal'
                    ],
                    'en' => [
                        'name' => 'More fatigued than normal'
                    ],
                    'code' => 'more_fatigued_normal',
                    'image' => 'face_bad',
                    'charge' => 2,
                ],
                [
                    'es' => [
                        'name' => 'Normal'
                    ],
                    'en' => [
                        'name' => 'Normal'
                    ],
                    'code' => 'normal',
                    'image' => 'face_regular',
                    'charge' => 3,
                ],
                [
                    'es' => [
                        'name' => 'Recuperado'
                    ],
                    'en' => [
                        'name' => 'Recovered'
                    ],
                    'code' => 'recovered',
                    'image' => 'face_good',
                    'charge' => 4,
                ],
                [
                    'es' => [
                        'name' => 'Muy recuperado'
                    ],
                    'en' => [
                        'name' => 'Very recovered'
                    ],
                    'code' => 'very_recovered',
                    'image' => 'face_very_good',
                    'charge' => 5,
                ],
            ],
            'muscle_pain' => [
                [
                    'es' => [
                        'name' => 'Muy dolorido'
                    ],
                    'en' => [
                        'name' => 'Very sore'
                    ],
                    'code' => 'very_sore',
                    'image' => 'face_very_bad',
                    'charge' => 1,
                ],
                [
                    'es' => [
                        'name' => 'Aumento del dolor muscular'
                    ],
                    'en' => [
                        'name' => 'Increased muscle pain'
                    ],
                    'code' => 'increased_muscle_pain',
                    'image' => 'face_bad',
                    'charge' => 2,
                ],
                [
                    'es' => [
                        'name' => 'Normal'
                    ],
                    'en' => [
                        'name' => 'Normal'
                    ],
                    'code' => 'normal',
                    'image' => 'face_regular',
                    'charge' => 3,
                ],
                [
                    'es' => [
                        'name' => 'Buenas sensaciones'
                    ],
                    'en' => [
                        'name' => 'Good feelings'
                    ],
                    'code' => 'good_feelings',
                    'image' => 'face_good',
                    'charge' => 4,
                ],
                [
                    'es' => [
                        'name' => 'Muy buenas sensaciones'
                    ],
                    'en' => [
                        'name' => 'Very good feelings'
                    ],
                    'code' => 'very_good_feelings',
                    'image' => 'face_very_good',
                    'charge' => 5,
                ],
            ],
            'mood' => [
                [
                    'es' => [
                        'name' => 'Muy molesto'
                    ],
                    'en' => [
                        'name' => 'Very angry'
                    ],
                    'code' => 'very_angry',
                    'image' => 'face_very_bad',
                    'charge' => 1,
                ],
                [
                    'es' => [
                        'name' => 'Mal genio'
                    ],
                    'en' => [
                        'name' => 'Bad mood'
                    ],
                    'code' => 'bad_mood',
                    'image' => 'face_bad',
                    'charge' => 2,
                ],
                [
                    'es' => [
                        'name' => 'Menos interesado en otras actividades de lo normal'
                    ],
                    'en' => [
                        'name' => 'Less interested than normal in other activities'
                    ],
                    'code' => 'less_interested',
                    'image' => 'face_regular',
                    'charge' => 3,
                ],
                [
                    'es' => [
                        'name' => 'Buen humor'
                    ],
                    'en' => [
                        'name' => 'Good mood'
                    ],
                    'code' => 'good_mood',
                    'image' => 'face_good',
                    'charge' => 4,
                ],
                [
                    'es' => [
                        'name' => 'Muy positivo'
                    ],
                    'en' => [
                        'name' => 'Very positive'
                    ],
                    'code' => 'very_positive',
                    'image' => 'face_very_good',
                    'charge' => 5,
                ],
            ],
        ];

        return $values[$key];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAnswerItems();
    }
}
