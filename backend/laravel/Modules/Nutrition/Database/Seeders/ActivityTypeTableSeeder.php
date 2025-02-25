<?php

namespace Modules\Nutrition\Database\Seeders;

use Illuminate\Database\Seeder;
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
                    'name' => 'Una ficha nutricional ha sido creada'
                ],
                'en' => [
                    'name' => 'Nutritional Sheet has been created'
                ],
                'code' => 'nutritional_sheet_created'
            ],
            [
                'es' => [
                    'name' => 'Una ficha nutricional ha sido actualizada'
                ],
                'en' => [
                    'name' => 'Nutritional Sheet has been updated'
                ],
                'code' => 'nutritional_sheet_updated'
            ],
            [
                'es' => [
                    'name' => 'Una ficha nutricional ha sido eliminada'
                ],
                'en' => [
                    'name' => 'Nutritional Sheet has been deleted'
                ],
                'code' => 'nutritional_sheet_deleted'
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
