<?php

namespace Modules\Injury\Database\Seeders;

use App\Services\BaseSeeder;
use App\Traits\ResourceTrait;
use Modules\Injury\Repositories\Interfaces\InjuryTypeRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryTypeSpecRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;

class InjuryTypeSpecTableSeeder extends BaseSeeder
{
    use ResourceTrait;

    /**
     * @var object
     */
    protected $injuryTypeSpecRepository;
    
    /**
     * @var object
     */
    protected $injuryTypeRepository;


    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(
        InjuryTypeSpecRepositoryInterface $injuryTypeSpecRepository,
        InjuryTypeRepositoryInterface $injuryTypeRepository,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->injuryTypeSpecRepository = $injuryTypeSpecRepository;
        $this->injuryTypeRepository = $injuryTypeRepository;
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * @return \Iterator
     */
    private function getInjurySpecs($code)
    {
        $injury_specs = [
            'traumatic_injury' => [
                [
                    'es' => [
                        'name' => 'Contusión / hematoma'
                    ],
                    'en' => [
                        'name' => 'Contusion / bruise'
                    ],
                    'code' => 'contusion_bruise',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Conmoción cerebral'
                    ],
                    'en' => [
                        'name' => 'Concussion'
                    ],
                    'code' => 'concussion',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Dislocación ósea'
                    ],
                    'en' => [
                        'name' => 'Bone dislocation'
                    ],
                    'code' => 'bone_dislocation',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Distensión muscular'
                    ],
                    'en' => [
                        'name' => 'Muscle strain'
                    ],
                    'code' => 'muscle_strain',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Distensión tendinosa'
                    ],
                    'en' => [
                        'name' => 'Tendon strain'
                    ],
                    'code' => 'tendon_strain',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Esguince de ligamento'
                    ],
                    'en' => [
                        'name' => 'Ligament strain'
                    ],
                    'code' => 'ligament_strain',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Esguince de cápsula articular'
                    ],
                    'en' => [
                        'name' => 'Joint capsule sprain'
                    ],
                    'code' => 'joint_capsule_sprain',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Fractura ósea'
                    ],
                    'en' => [
                        'name' => 'Bone fracture'
                    ],
                    'code' => 'bone_fracture',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Rotura de menisco'
                    ],
                    'en' => [
                        'name' => 'Meniscus tear'
                    ],
                    'code' => 'meniscus_tear',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Otras (especificar)'
                    ],
                    'en' => [
                        'name' => 'Others (specify)'
                    ],
                    'code' => 'others',
                    'image_id' => ''
                ],
            ],
            'overuse_injury' => [
                [
                    'es' => [
                        'name' => 'Lesión de cartílago'
                    ],
                    'en' => [
                        'name' => 'Cartilage injury'
                    ],
                    'code' => 'cartilage',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Lesión de cápsula articular'
                    ],
                    'en' => [
                        'name' => 'Joint capsule injury'
                    ],
                    'code' => 'joint_capsule',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Lesión de ligamento'
                    ],
                    'en' => [
                        'name' => 'Ligament injury'
                    ],
                    'code' => 'ligament',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Lesión de menisco'
                    ],
                    'en' => [
                        'name' => 'Meniscus injury'
                    ],
                    'code' => 'meniscus',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Lesión muscular'
                    ],
                    'en' => [
                        'name' => 'Muscle injury'
                    ],
                    'code' => 'muscle',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Lesión ósea'
                    ],
                    'en' => [
                        'name' => 'Bone injury'
                    ],
                    'code' => 'bone',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Lesión tendinosa'
                    ],
                    'en' => [
                        'name' => 'Tendon injury'
                    ],
                    'code' => 'tendon',
                    'image_id' => ''
                ],
                [
                    'es' => [
                        'name' => 'Otras (especificar)'
                    ],
                    'en' => [
                        'name' => 'Others (specify)'
                    ],
                    'code' => 'others',
                    'image_id' => ''
                ],
            ],
        ];

        return $injury_specs[$code];
    }

    /**
     * Loops through every injury type and insert theirs specifications
     */
    private function createInjuryTypeSpecs()
    {
        $injury_types = $this->injuryTypeRepository->findAll();

        foreach ($injury_types as $injury_type) {
            $injury_specs = $this->getInjurySpecs($injury_type->code);

            foreach ($injury_specs as $specs) {

                $params['directory']= "injury_type";
                $params['name']= $specs['code'];
                $image = $this->getImage($params);
    
                $dataResource = $this->uploadResource('/injuries/type', $image);
    
                $resource = $this->resourceRepository->create($dataResource);

                $specs['image_id'] =  $resource->id;

                $specs['injury_type_id'] = $injury_type->id;
                $this->injuryTypeSpecRepository->create($specs);
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
        $this->createInjuryTypeSpecs();
    }
}
