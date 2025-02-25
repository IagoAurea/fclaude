<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\ClinicalTestTypeRepositoryInterface;

class ClinicalTestTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $clinicalTestTypeRepository;

    public function __construct(ClinicalTestTypeRepositoryInterface $clinicalTestTypeRepository)
    {
        $this->clinicalTestTypeRepository = $clinicalTestTypeRepository;
    }

    /**
     * @return void
     */
    protected function createClinicalTestType(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->clinicalTestTypeRepository->create($elm);
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
                    'name' => 'Radiografía'
                ],
                'en' => [
                    'name' => 'X-ray'
                ],
                'code' => 'clinical_test_type_x_ray'
            ],
            [
                'es' => [
                    'name' => 'Ecografía'
                ],
                'en' => [
                    'name' => 'Ultrasound'
                ],
                'code' => 'clinical_test_type_ultrasound'
            ],
            [
                'es' => [
                    'name' => 'Gammagrafía'
                ],
                'en' => [
                    'name' => 'Scintigraphy'
                ],
                'code' => 'clinical_test_type_scintigraphy'
            ],
            [
                'es' => [
                    'name' => 'TAC (Tomografía Computarizada de la Cabeza)'
                ],
                'en' => [
                    'name' => 'CTH (Computed Tomography of the Head)'
                ],
                'code' => 'clinical_test_type_cth'
            ],
            [
                'es' => [
                    'name' => 'RMN (Resonancia Magnética Nuclear)'
                ],
                'en' => [
                    'name' => 'NMR (Nuclear Magnetic Resonance)'
                ],
                'code' => 'clinical_test_type_mnr'
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
        $this->createClinicalTestType($this->get()->current());
    }
}
