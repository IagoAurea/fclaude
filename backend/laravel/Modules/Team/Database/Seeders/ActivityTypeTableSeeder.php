<?php

namespace Modules\Team\Database\Seeders;

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
    public function __construct(ActivityTypeRepositoryInterface $activityTypeRepository)
    {
        $this->activityTypeRepository = $activityTypeRepository;
    }

    /**
     * Loop thorugh all the array of activity codes and insert them into the database
     *
     * @return void
     */
    protected function createActivities(array $elements)
    {
        foreach ($elements as $elm) {
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
                    'name' => 'El equipo ha sido creado'
                ],
                'en' => [
                    'name' => 'The Team has been created'
                ],
                'code' => 'team_created'
            ],
            [
                'es' => [
                    'name' => 'El equipo ha sido actualizada'
                ],
                'en' => [
                    'name' => 'The Team has been updated'
                ],
                'code' => 'team_updated'
            ],
            [
                'es' => [
                    'name' => 'El equipo ha sido borrado'
                ],
                'en' => [
                    'name' => 'The Team has been deleted'
                ],
                'code' => 'team_deleted'
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
