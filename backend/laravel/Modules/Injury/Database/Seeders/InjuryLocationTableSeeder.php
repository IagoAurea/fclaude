<?php

namespace Modules\Injury\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Injury\Repositories\Interfaces\InjuryLocationRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class InjuryLocationTableSeeder extends BaseSeeder
{
    use ResourceTrait;
    
    /**
     * @var object
     */
    protected $injuryLocationRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(
        InjuryLocationRepositoryInterface $injuryLocationRepository,
        ResourceRepositoryInterface $resourceRepository
    )
    {
        $this->injuryLocationRepository = $injuryLocationRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return void
     */
    protected function createInjuryLocation(array $elements)
    {
        foreach($elements as $elm)
        {
            $params['directory']= "injury_location";
            $params['name']= $elm['code'];
            $image = $this->getImage($params);

            $dataResource = $this->uploadResource('/injuries/location', $image);

            $resource = $this->resourceRepository->create($dataResource);

            $elm['image_id'] =  $resource->id;

            $this->injuryLocationRepository->create($elm);
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
                    'name' => 'Cabeza / Cara'
                ],
                'en' => [
                    'name' => 'Head / face'
                ],
                'code' => 'head_face',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Cuello / Columna cervical'
                ],
                'en' => [
                    'name' => 'Neck / Cervical spine'
                ],
                'code' => 'neck_cervical',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Hombro / clavícula'
                ],
                'en' => [
                    'name' => 'Shoulder / clavicle'
                ],
                'code' => 'shoulder_clavicle',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Brazo'
                ],
                'en' => [
                    'name' => 'Arm'
                ],
                'code' => 'arm',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Codo'
                ],
                'en' => [
                    'name' => 'Elbow'
                ],
                'code' => 'elbow',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Antebrazo'
                ],
                'en' => [
                    'name' => 'Forearm'
                ],
                'code' => 'forearm',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Muñeca'
                ],
                'en' => [
                    'name' => 'Wrist'
                ],
                'code' => 'wrist',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => ' Manos / dedos / pulgar'
                ],
                'en' => [
                    'name' => 'Hands / fingers / thumb'
                ],
                'code' => 'hands_fingers',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Esternón / costillas'
                ],
                'en' => [
                    'name' => 'Sternum / ribs'
                ],
                'code' => 'sternum_ribs',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Abdomen'
                ],
                'en' => [
                    'name' => 'Abdomen'
                ],
                'code' => 'abdomen',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Espalda alta'
                ],
                'en' => [
                    'name' => 'High back'
                ],
                'code' => 'high_back',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Espalda baja / sacro'
                ],
                'en' => [
                    'name' => 'Lower back / sacrum'
                ],
                'code' => 'lower_back_sacrum',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Pelvis / Cadera / Ingle'
                ],
                'en' => [
                    'name' => 'Pelvis / Hip / Groin'
                ],
                'code' => 'pelvis_hip_groin',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Muslo'
                ],
                'en' => [
                    'name' => 'Thigh'
                ],
                'code' => 'thigh',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Rodilla'
                ],
                'en' => [
                    'name' => 'Knee'
                ],
                'code' => 'knee',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Pierna / tendón de Aquiles'
                ],
                'en' => [
                    'name' => 'Leg / Achilles tendon'
                ],
                'code' => 'leg_tendon',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Tobillo'
                ],
                'en' => [
                    'name' => 'Ankle'
                ],
                'code' => 'ankle',
                'image_id' => ''
            ],
            [
                'es' => [
                    'name' => 'Pie y dedos del pie'
                ],
                'en' => [
                    'name' => 'Foot and toes'
                ],
                'code' => 'foot_toes',
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
        $this->createInjuryLocation($this->get()->current());
    }
}
