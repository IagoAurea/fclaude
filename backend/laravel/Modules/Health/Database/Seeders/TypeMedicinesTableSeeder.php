<?php

namespace Modules\Health\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Health\Repositories\Interfaces\TypeMedicineRepositoryInterface;


class TypeMedicinesTableSeeder extends Seeder
{
    /**
     * @var $medicineRepository
     */
    protected $medicineRepository;

    public function __construct(TypeMedicineRepositoryInterface $medicineRepository)
    {
        $this->medicineRepository = $medicineRepository;
    }

    /**
     * @return void
     */
    protected function createTypeMedicine(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->medicineRepository->create($elm);
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
                    'name' => 'Analgésicos'
                ],
                'en' => [
                    'name' => 'Analgesics'
                ],
                'code' => 'analgesics'
            ],
            [
                'es' => [
                    'name' => 'Antiácidos y antiulcerosos'
                ],
                'en' => [
                    'name' => 'Antacids and anti-ulcer drugs'
                ],
                'code' => 'antacids_anti_ulcer'
            ],
            [
                'es' => [
                    'name' => 'Antialérgicos'
                ],
                'en' => [
                    'name' => 'Antiallergic'
                ],
                'code' => 'antiallergic'
            ],
            [
                'es' => [
                    'name' => 'Antidiarreicos y laxantes'
                ],
                'en' => [
                    'name' => 'Antidiarrheals and laxatives'
                ],
                'code' => 'Antidiarrheals_laxatives'
            ],
            [
                'es' => [
                    'name' => 'Antiinflamatorios'
                ],
                'en' => [
                    'name' => 'Anti-inflammatories'
                ],
                'code' => 'anti_inflammatories'
            ],
            [
                'es' => [
                    'name' => 'Antipiréticos'
                ],
                'en' => [
                    'name' => 'Antipyretics'
                ],
                'code' => 'antipyretics'
            ],
            [
                'es' => [
                    'name' => 'Antitusivos y mucolíticos'
                ],
                'en' => [
                    'name' => 'Antitussives and mucolytics'
                ],
                'code' => 'antitussives_mucolytics'
            ],
            [
                'es' => [
                    'name' => 'Antiinfecciosos'
                ],
                'en' => [
                    'name' => 'Anti-infectives'
                ],
                'code' => 'anti_infectives'
            ],
            [
                'es' => [
                    'name' => 'Otras'
                ],
                'en' => [
                    'name' => 'Other'
                ],
                'code' => 'other'
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
        $this->createTypeMedicine($this->get()->current());
    }
}
