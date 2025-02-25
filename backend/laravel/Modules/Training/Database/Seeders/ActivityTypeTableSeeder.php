<?php

namespace Modules\Training\Database\Seeders;

use Illuminate\Database\Seeder;

// Repositories
use Modules\Activity\Repositories\Interfaces\ActivityTypeRepositoryInterface;

class ActivityTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $activityTypeRepository;

    /**
     * Instance a new table seeder
     */
    public function __construct(ActivityTypeRepositoryInterface $activityTypeRepository) {
        $this->activityTypeRepository = $activityTypeRepository;
    }

    /**
     * Loop thorugh all the array of activity codes and insert them into the database
     * 
     * @return void
     */
    protected function createActivities(array $elements)
    {
        foreach($elements as $elm) {
            $this->activityTypeRepository->create($elm);
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
                    'name' => 'Una Sesión de ejercicios ha sido creado'
                ],
                'en' => [
                    'name' => 'Exercise session has been created'
                ],
                'code' => 'exercise_session_created'
            ],
            [
                'es' => [
                    'name' => 'Una Sesión de ejercicios  ha sido actualizada'
                ],
                'en' => [
                    'name' => 'Exercise session has been updated'
                ],
                'code' => 'exercise_session_updated'
            ],
            [
                'es' => [
                    'name' => 'Una Sesión de ejercicios ha sido eliminada'
                ],
                'en' => [
                    'name' => 'Exercise session has been deleted'
                ],
                'code' => 'exercise_session_deleted'
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
        $this->createActivities($this->get()->current());
    }
}
