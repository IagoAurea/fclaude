<?php

namespace Modules\Training\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Training\Repositories\Interfaces\TypeExerciseSessionRepositoryInterface;

class TypeExerciseSessionsTableSeeder extends Seeder
{
   /**
     * @var object
     */
    protected $typeExerciseSessionRepository;

    public function __construct(TypeExerciseSessionRepositoryInterface $typeExerciseSessionRepository)
    {
        $this->typeExerciseSessionRepository = $typeExerciseSessionRepository;
    }

    /**
     * @return void
     */
    protected function createTypeExerciseSessions(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->typeExerciseSessionRepository->create($elm);
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
                    'name' => 'Principal'
                ],
                'en' => [
                    'name' => 'Main/Core'
                ],
                'code' => 'principal'
            ],
            [
                'es' => [
                    'name' => 'Complementaria'
                ],
                'en' => [
                    'name' => 'Complementary'
                ],
                'code' => 'complementary'
            ],
            [
                'es' => [
                    'name' => 'Preventiva'
                ],
                'en' => [
                    'name' => 'Preventive'
                ],
                'code' => 'preventive'
            ],
            [
                'es' => [
                    'name' => 'Regenerativa'
                ],
                'en' => [
                    'name' => 'Regenerative'
                ],
                'code' => 'regenerative'
            ],
            [
                'es' => [
                    'name' => 'RFD lesiones'
                ],
                'en' => [
                    'name' => 'RFD lesions'
                ],
                'code' => 'lesions'
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
        $this->createTypeExerciseSessions($this->get()->current());
    }
}
