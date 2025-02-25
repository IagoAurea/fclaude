<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Generality\Repositories\Interfaces\SeasonRepositoryInterface;

class SeasonsTableSeeder extends Seeder
{
    const NUMBER_YEAR_GENERATE = 20;

     /**
     * @var object
     */
    protected $seasonRepository;

    public function __construct(SeasonRepositoryInterface $seasonRepository)
    {
        $this->seasonRepository = $seasonRepository;
    }

    /**
     * @return void
     */
    protected function createSeason()
    {
        $current = now()->format('Y');
        
        $end = $current;

        for($i=1; $i <= self::NUMBER_YEAR_GENERATE; $i++)
        {
            $start = $end;

            $end = $current + $i;

            $this->seasonRepository->create([
                'start' => $start,
                'end' => $end
            ]);
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createSeason();
    }
}
