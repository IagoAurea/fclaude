<?php

namespace Modules\Injury\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryLocationRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjurySeverityRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjurySeverityLocationRepositoryInterface;

class InjurySeverityLocationTableSeeder extends BaseSeeder
{
    use ResourceTrait;
    
    /**
     * @var $injuryLocationRepository
     */
    protected $injuryLocationRepository;
    
    /**
     * @var $injurySeverityRepository
     */
    protected $injurySeverityRepository;
    
    /**
     * @var $injurySeverityLocationRepository
     */
    protected $injurySeverityLocationRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(
        InjuryLocationRepositoryInterface $injuryLocationRepository,
        InjurySeverityRepositoryInterface $injurySeverityRepository,
        InjurySeverityLocationRepositoryInterface $injurySeverityLocationRepository,
        ResourceRepositoryInterface $resourceRepository
    )
    {
        $this->injuryLocationRepository = $injuryLocationRepository;
        $this->injurySeverityRepository = $injurySeverityRepository;
        $this->injurySeverityLocationRepository = $injurySeverityLocationRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createInjurySeverityLocation(array $elements)
    {
        $severities = $this->injurySeverityRepository->findAll();

        $locations = $this->injuryLocationRepository->findAll();


        foreach($severities as $severity)
        {
            foreach($locations as $location) {

                $params['directory']= "injury_location";
                $params['name']= $severity->code . '_' . $location->code; 
                $image = $this->getImage($params);

                $dataResource = $this->uploadResource('/injuries/location', $image);

                $resource = $this->resourceRepository->create($dataResource);
                $data = [
                    'image_id' => $resource->id,
                    'severity_id' => $severity->id,
                    'location_id' => $location->id
                ];
    
                $this->injurySeverityLocationRepository->create($data);
            }
        }
    }

     /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                
                'code' => 'severity_minimum',
                'locations' => [
                    [
                        'code' => 'head_face',
                        'image' => 'head_face_minimum'
                    ],
                    [
                        'code' => 'neck_cervical',
                        'image' => 'neck_cervical_minimum'
                    ],
                    [
                        'code' => 'shoulder_clavicle',
                        'image' => 'shoulder_clavicle_minimum'
                    ],
                    [
                        'code' => 'arm',
                        'image' => 'arm_minimum'
                    ],
                    [
                        'code' => 'elbow',
                        'image' => 'elbow_minimum'
                    ],
                    [
                        'code' => 'forearms',
                        'image' => 'forearms_minimum'
                    ],
                    [
                        'code' => 'wrist',
                        'image' => 'wrist_minimum'
                    ],
                    [
                        'code' => 'hands_fingers',
                        'image' => 'hands_fingers_minimum'
                    ],
                    [
                        'code' => 'sternum_ribs',
                        'image' => 'sternum_ribs_minimum'
                    ],
                    [
                        'code' => 'abdomen',
                        'image' => 'abdomen_minimum'
                    ],
                    [
                        'code' => 'high_back',
                        'image' => 'high_back_minimum'
                    ],
                    [
                        'code' => 'lower_back_sacrum',
                        'image' => 'lower_back_sacrum_minimum'
                    ],
                    [
                        'code' => 'pelvis_hip_groin',
                        'image' => 'pelvis_hip_groin_minimum'
                    ],
                    [
                        'code' => 'thigh',
                        'image' => 'thigh_minimum'
                    ],
                    [
                        'code' => 'knee',
                        'image' => 'knee_minimum'
                    ],
                    [
                        'code' => 'leg_tendon',
                        'image' => 'leg_tendon_minimum'
                    ],
                    [
                        'code' => 'ankle',
                        'image' => 'ankle_minimum'
                    ],
                    [
                        'code' => 'foot_toes',
                        'image' => 'foot_toes_minimum'
                    ],
                ]
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
        $this->createInjurySeverityLocation($this->get()->current());
    }
}
