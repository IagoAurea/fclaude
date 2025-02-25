<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Generality\Repositories\Interfaces\StudyLevelRepositoryInterface;

class StudyLevelsTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $studyLevelRepository;

    public function __construct(StudyLevelRepositoryInterface $studyLevelRepository)
    {
        $this->studyLevelRepository = $studyLevelRepository;
    }

    /**
     * @return void
     */
    protected function createStudyLevels(array $elements)
    {
        foreach($elements as $elm) 
        {
            $this->studyLevelRepository->create($elm);
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
                    'name' => 'Educación Infantil'
                ],
                'en' => [
                    'name' => 'Early Childhood Education'
                ],
                'code' => 'early_education'
            ],
            [
                'es' => [
                    'name' => 'Educación Primaria'
                ],
                'en' => [
                    'name' => 'Primary Education'
                ],
                'code' => 'primary_education'
            ],
            [
                'es' => [
                    'name' => 'Educación Secundaria Obligatoria (ESO)'
                ],
                'en' => [
                    'name' => 'Compulsory Secondary Education (ESO)'
                ],
                'code' => 'secondary_education'
            ],
            [
                'es' => [
                    'name' => 'Bachillerato'
                ],
                'en' => [
                    'name' => 'Baccalaureate'
                ],
                'code' => 'baccalaureate'
            ],
            [
                'es' => [
                    'name' => 'Formación Profesional (FP)'
                ],
                'en' => [
                    'name' => 'Vocational Training (VET)'
                ],
                'code' => 'vocational_training'
            ],
            [
                'es' => [
                    'name' => 'Enseñanzas universitarias'
                ],
                'en' => [
                    'name' => 'University education'
                ],
                'code' => 'university_education'
            ],
            [
                'es' => [
                    'name' => 'Enseñanzas de régimen especial'
                ],
                'en' => [
                    'name' => 'Special education'
                ],
                'code' => 'special_education'
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
        $this->createStudyLevels($this->get()->current());
    }
}
