<?php

namespace Modules\Fisiotherapy\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Fisiotherapy\Repositories\Interfaces\TreatmentRepositoryInterface;

class TreatmentTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $treatmentRepository;

    public function __construct(TreatmentRepositoryInterface $treatmentRepository)
    {
        $this->treatmentRepository = $treatmentRepository;
    }


    /**
     * @return void
     */
    protected function createTreatment(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->treatmentRepository->create($elm);
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
                    'name' => 'Biofeedback'
                ],
                'en' => [
                    'name' => 'Biofeedback'
                ],
                'code' => 'biofeedback'
            ],
            [
                'es' => [
                    'name' => 'Cinesiterapia'
                ],
                'en' => [
                    'name' => 'Kinesitherapy'
                ],
                'code' => 'kinesitherapy'
            ],
            [
                'es' => [
                    'name' => 'Ejercicio terapéutico'
                ],
                'en' => [
                    'name' => 'Therapeutic exercise'
                ],
                'code' => 'therapeutic_exercise'
            ],
            [
                'es' => [
                    'name' => 'Electroterapia'
                ],
                'en' => [
                    'name' => 'Electrotherapy'
                ],
                'code' => 'electrotherapy'
            ],
            [
                'es' => [
                    'name' => 'Laserterapia'
                ],
                'en' => [
                    'name' => 'Lasertherapy'
                ],
                'code' => 'lasertherapy'
            ],
            [
                'es' => [
                    'name' => 'Magnetoterapia'
                ],
                'en' => [
                    'name' => 'Magnetotherapy'
                ],
                'code' => 'magnetotherapy'
            ],
            [
                'es' => [
                    'name' => 'Masoterapia'
                ],
                'en' => [
                    'name' => 'Masotherapy'
                ],
                'code' => 'masotherapy'
            ],
            [
                'es' => [
                    'name' => 'Electrólisis Percutánea Intratisular'
                ],
                'en' => [
                    'name' => 'Percutaneous Intratisular Electrolysis'
                ],
                'code' => 'pie'
            ],
            [
                'es' => [
                    'name' => 'Electrólisis Percutánea Terapéutica'
                ],
                'en' => [
                    'name' => 'Therapeutic Percutaneous Electrolysis'
                ],
                'code' => 'epte'
            ],
            [
                'es' => [
                    'name' => 'Neuromodulación percutánea'
                ],
                'en' => [
                    'name' => 'Percutaneous neuromodulation'
                ],
                'code' => 'percutaneous_neuromodulation'
            ],
            [
                'es' => [
                    'name' => 'Punción seca'
                ],
                'en' => [
                    'name' => 'Dry needling'
                ],
                'code' => 'dry_needling'
            ],
            [
                'es' => [
                    'name' => 'Termoterapia'
                ],
                'en' => [
                    'name' => 'Thermotherapy'
                ],
                'code' => 'thermotherapy'
            ],
            [
                'es' => [
                    'name' => 'Tecarterapia'
                ],
                'en' => [
                    'name' => 'Tecartherapy'
                ],
                'code' => 'tecartherapy'
            ],
            [
                'es' => [
                    'name' => 'Neurodinamia'
                ],
                'en' => [
                    'name' => 'Neurodynamics'
                ],
                'code' => 'neurodynamics'
            ],
            [
                'es' => [
                    'name' => 'Realidad virtual'
                ],
                'en' => [
                    'name' => 'Virtual reality'
                ],
                'code' => 'virtual_reality'
            ],
            [
                'es' => [
                    'name' => 'Terapia manual'
                ],
                'en' => [
                    'name' => 'Manual therapy'
                ],
                'code' => 'manual_therapy'
            ],
            [
                'es' => [
                    'name' => 'Presoterapia'
                ],
                'en' => [
                    'name' => 'Pressotherapy'
                ],
                'code' => 'pressotherapy'
            ],
            [
                'es' => [
                    'name' => 'Hidroterapia'
                ],
                'en' => [
                    'name' => 'Hydrotherapy'
                ],
                'code' => 'hydrotherapy'
            ],
            [
                'es' => [
                    'name' => 'Pilates'
                ],
                'en' => [
                    'name' => 'Pilates'
                ],
                'code' => 'pilates'
            ],
            [
                'es' => [
                    'name' => 'Vendajes'
                ],
                'en' => [
                    'name' => 'Bandages'
                ],
                'code' => 'bandages'
            ],
            [
                'es' => [
                    'name' => 'Quiropraxia'
                ],
                'en' => [
                    'name' => 'Chiropractic'
                ],
                'code' => 'chiropractic'
            ],
            [
                'es' => [
                    'name' => 'Osteopatía'
                ],
                'en' => [
                    'name' => 'Osteopathy'
                ],
                'code' => 'osteopathy'
            ],
            [
                'es' => [
                    'name' => 'Otras'
                ],
                'en' => [
                    'name' => 'Others'
                ],
                'code' => 'others'
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
        $this->createTreatment($this->get()->current());
    }
}
