<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Generality\Repositories\Interfaces\WeekDayRepositoryInterface;


class WeekDayTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $weekDayRepository;

    public function __construct(WeekDayRepositoryInterface $weekDayRepository)
    {
        $this->weekDayRepository = $weekDayRepository;
    }

    /**
     * @return void
     */
    protected function createWeekDay(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->weekDayRepository->create($elm);
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
                    'name' => 'Lunes'
                ],
                'en' => [
                    'name' => 'Monday'
                ],
                'code' => 'monday'
            ],
            [
                'es' => [
                    'name' => 'Martes'
                ],
                'en' => [
                    'name' => 'Tuesday'
                ],
                'code' => 'tuesday'
            ],
            [
                'es' => [
                    'name' => 'Miércoles'
                ],
                'en' => [
                    'name' => 'Wednesday'
                ],
                'code' => 'wednesday'
            ],
            [
                'es' => [
                    'name' => 'Jueves'
                ],
                'en' => [
                    'name' => 'Thursday'
                ],
                'code' => 'thursday'
            ],
            [
                'es' => [
                    'name' => 'Viernes'
                ],
                'en' => [
                    'name' => 'Friday'
                ],
                'code' => 'friday'
            ],
            [
                'es' => [
                    'name' => 'Sábado'
                ],
                'en' => [
                    'name' => 'Saturday'
                ],
                'code' => 'saturday'
            ],
            [
                'es' => [
                    'name' => 'Domingo'
                ],
                'en' => [
                    'name' => 'Sunday'
                ],
                'code' => 'sunday'
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
        $this->createWeekDay($this->get()->current());
    }
}
