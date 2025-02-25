<?php

namespace Modules\InjuryPrevention\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\InjuryPrevention\Repositories\Interfaces\PreventiveProgramTypeRepositoryInterface;

class PreventiveProgramTypeTableSeeder extends Seeder
{

    /**
     * @var object
     */
    protected $preventiveProgramTypeRepository;

    /**
     * Creates a new seeder instance
     */
    public function __construct(PreventiveProgramTypeRepositoryInterface $preventiveProgramTypeRepository)
    {
        $this->preventiveProgramTypeRepository = $preventiveProgramTypeRepository;
    }

    /**
     * @return void
     */
    protected function createPreventiveProgramTypes(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->preventiveProgramTypeRepository->create($elm);
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
                    'name' => 'Calentamiento'
                ],
                'en' => [
                    'name' => 'Warm up'
                ],
                'code' => 'warm_up'
            ],
            [
                'es' => [
                    'name' => 'Fortalecimiento'
                ],
                'en' => [
                    'name' => 'Strengthening'
                ],
                'code' => 'strengthening'
            ],
            [
                'es' => [
                    'name' => 'CORE'
                ],
                'en' => [
                    'name' => 'CORE'
                ],
                'code' => 'core'
            ],
            [
                'es' => [
                    'name' => 'Estiramiento'
                ],
                'en' => [
                    'name' => 'Stretching'
                ],
                'code' => 'stretching'
            ],
            [
                'es' => [
                    'name' => 'Propiocepción'
                ],
                'en' => [
                    'name' => 'Proprioception'
                ],
                'code' => 'proprioception'
            ],
            [
                'es' => [
                    'name' => 'Agilidad'
                ],
                'en' => [
                    'name' => 'Agility'
                ],
                'code' => 'agility'
            ],
            [
                'es' => [
                    'name' => 'Reeducación de habilidades'
                ],
                'en' => [
                    'name' => 'Reeducation of skills'
                ],
                'code' => 'reeducation_of_skills'
            ],
            [
                'es' => [
                    'name' => 'Recuperación post-fatiga'
                ],
                'en' => [
                    'name' => 'Post-fatigue recovery'
                ],
                'code' => 'post_fatigue_recovery'
            ],
            [
                'es' => [
                    'name' => 'Técnicas de relajación'
                ],
                'en' => [
                    'name' => 'Relaxation techniques'
                ],
                'code' => 'relaxation_techniques'
            ],
            [
                'es' => [
                    'name' => 'Otro'
                ],
                'en' => [
                    'name' => 'Other'
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
        $this->createPreventiveProgramTypes($this->get()->current());
    }
}
