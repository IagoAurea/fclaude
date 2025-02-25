<?php

namespace Modules\Health\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Health\Repositories\Interfaces\AreaBodyRepositoryInterface;

class AreasBodyTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $areaBodyRepository;

    public function __construct(AreaBodyRepositoryInterface $areaBodyRepository)
    {
        $this->areaBodyRepository = $areaBodyRepository;
    }

    /**
     * @return void
     */
    protected function createAreaBody(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->areaBodyRepository->create($elm);
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
                    'name' => 'Head / Face'
                ],
                'code' => 'head_face'
            ],
            [
                'es' => [
                    'name' => 'Cuello / Columna cervical'
                ],
                'en' => [
                    'name' => 'Neck / Cervical spine'
                ],
                'code' => 'neck_cervical'
            ],
            [
                'es' => [
                    'name' => 'Hombro / clavícula'
                ],
                'en' => [
                    'name' => 'Shoulder / clavicle'
                ],
                'code' => 'shoulder_clavicle'
            ],
            [
                'es' => [
                    'name' => 'Brazo'
                ],
                'en' => [
                    'name' => 'Arm'
                ],
                'code' => 'arm'
            ],
            [
                'es' => [
                    'name' => 'Codo'
                ],
                'en' => [
                    'name' => 'Elbow'
                ],
                'code' => 'elbow'
            ],
            [
                'es' => [
                    'name' => 'Antebrazo'
                ],
                'en' => [
                    'name' => 'Forearm'
                ],
                'code' => 'forearm'
            ],
            [
                'es' => [
                    'name' => 'Muñeca'
                ],
                'en' => [
                    'name' => 'Doll'
                ],
                'code' => 'Doll'
            ],
            [
                'es' => [
                    'name' => 'Manos / dedos / pulgar'
                ],
                'en' => [
                    'name' => 'Hands / fingers / thumb'
                ],
                'code' => 'hands_fingers_thumb'
            ],
            [
                'es' => [
                    'name' => 'Esternón / costillas'
                ],
                'en' => [
                    'name' => 'Sternum / ribs'
                ],
                'code' => 'sternum_ribs'
            ],
            [
                'es' => [
                    'name' => 'Abdomen'
                ],
                'en' => [
                    'name' => 'Abdomen'
                ],
                'code' => 'abdomen'
            ],
            [
                'es' => [
                    'name' => 'Espalda alta'
                ],
                'en' => [
                    'name' => 'High back'
                ],
                'code' => 'high_back'
            ],
            [
                'es' => [
                    'name' => 'Espalda baja / sacro'
                ],
                'en' => [
                    'name' => 'Lower back / sacrum'
                ],
                'code' => 'lower_back_sacrum'
            ],
            [
                'es' => [
                    'name' => 'Pelvis / Cadera / Ingle'
                ],
                'en' => [
                    'name' => 'Pelvis / Hip / Groin'
                ],
                'code' => 'pelvis_hip_groin'
            ],
            [
                'es' => [
                    'name' => 'Muslo'
                ],
                'en' => [
                    'name' => 'Thigh'
                ],
                'code' => 'thigh'
            ],
            [
                'es' => [
                    'name' => 'Rodilla'
                ],
                'en' => [
                    'name' => 'Knee'
                ],
                'code' => 'knee'
            ],
            [
                'es' => [
                    'name' => 'Pierna / tendón de Aquiles'
                ],
                'en' => [
                    'name' => 'Leg / Achilles tendon'
                ],
                'code' => 'leg_achilles_tendon'
            ],
            [
                'es' => [
                    'name' => 'Tobillo'
                ],
                'en' => [
                    'name' => 'Ankle'
                ],
                'code' => 'ankle'
            ],
            [
                'es' => [
                    'name' => 'Pie y dedos del pie'
                ],
                'en' => [
                    'name' => 'Foot and toes'
                ],
                'code' => 'foot_toes'
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAreaBody($this->get()->current());
    }
}
