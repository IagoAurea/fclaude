<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Package\Repositories\Interfaces\SubpackageRepositoryInterface;
use Modules\Package\Repositories\Interfaces\SubpackageSportRepositoryInterface;

class SubpackageSportsTableSeeder extends Seeder
{
    /** 
     * @var object
     */
    protected $subpackageSportRepository;

    /** 
     * @var object
     */
    protected $subpackageRepository;

    /** 
     * @var object
     */
    protected $sportRepository;

    public function __construct(
        SubpackageSportRepositoryInterface $subpackageSportRepository,
        SubpackageRepositoryInterface $subpackageRepository,
        SportRepositoryInterface $sportRepository
    )
    {
        $this->subpackageSportRepository = $subpackageSportRepository;
        $this->subpackageRepository = $subpackageRepository;
        $this->sportRepository = $sportRepository;
    }

    /**
     * @return void
     */
    protected function createSubpackagesSport(array $elements)
    {
        foreach($elements as $element) 
        {
            $subpackage = $this->subpackageRepository->findOneBy(['code' => $element['subpackage_code']]);

            foreach($element['sports_code'] as $sport_code) {
                $sport = $this->sportRepository->findOneBy(['code' => $sport_code]);

                $this->subpackageSportRepository->create([
                    'subpackage_id' => $subpackage->id,
                    'sport_id' => $sport->id
                ]);
            }
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'subpackage_code' => 'teacher_bronze',
                'sports_code' => [
                    'football'
                ]
            ],
            [
                'subpackage_code' => 'teacher_silver',
                'sports_code' => [
                    'football',
                    'swimming',
                    'fitness'
                ]
            ],
            [
                'subpackage_code' => 'teacher_gold',
                'sports_code' => [
                    'football',
                    'swimming',
                    'fitness',
                    'sports_hall',
                    'outdoor_sports_track'
                ]
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
        $this->createSubpackagesSport($this->get()->current());
    }
}
