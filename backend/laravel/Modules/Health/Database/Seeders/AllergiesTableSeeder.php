<?php

namespace Modules\Health\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Health\Repositories\Interfaces\AllergyRepositoryInterface;

class AllergiesTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $allergyRepository;

    public function __construct(AllergyRepositoryInterface $allergyRepository)
    {
        $this->allergyRepository = $allergyRepository;
    }

    /**
     * @return void
     */
    protected function createAllergy(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->allergyRepository->create($elm);
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
                    'name' => 'Polen'
                ],
                'en' => [
                    'name' => 'Pollen'
                ],
                'code' => 'pollen'
            ],
            [
                'es' => [
                    'name' => 'Ácaros'
                ],
                'en' => [
                    'name' => 'Mites'
                ],
                'code' => 'mites'
            ],
            [
                'es' => [
                    'name' => 'Moho'
                ],
                'en' => [
                    'name' => 'Mold'
                ],
                'code' => 'mold'
            ],
            [
                'es' => [
                    'name' => 'Caspa animal'
                ],
                'en' => [
                    'name' => 'Animal dander'
                ],
                'code' => 'animal_dander'
            ],
            [
                'es' => [
                    'name' => 'Insectos'
                ],
                'en' => [
                    'name' => 'Insects'
                ],
                'code' => 'insects'
            ],
            [
                'es' => [
                    'name' => 'Medicamentos'
                ],
                'en' => [
                    'name' => 'Medications'
                ],
                'code' => 'medications'
            ],
            [
                'es' => [
                    'name' => 'Alimentos'
                ],
                'en' => [
                    'name' => 'Foods'
                ],
                'code' => 'foods'
            ],
            [
                'es' => [
                    'name' => 'Látex'
                ],
                'en' => [
                    'name' => 'Latex'
                ],
                'code' => 'latex'
            ],
            [
                'es' => [
                    'name' => 'Otras'
                ],
                'en' => [
                    'name' => 'Other'
                ],
                'code' => 'other'
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
        $this->createAllergy($this->get()->current());
    }
}
