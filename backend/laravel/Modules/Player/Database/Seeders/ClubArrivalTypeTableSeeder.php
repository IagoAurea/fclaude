<?php

namespace Modules\Player\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Player\Repositories\Interfaces\ClubArrivalTypeRepositoryInterface;

class ClubArrivalTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $clubArrivalTypeRepository;

    public function __construct(ClubArrivalTypeRepositoryInterface $clubArrivalTypeRepository)
    {
        $this->clubArrivalTypeRepository = $clubArrivalTypeRepository;
    }

    /**
     * @return void
     */
    protected function createClubArrivalType(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->clubArrivalTypeRepository->create($elm);
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
                    'name' => 'Cantera'
                ],
                'en' => [
                    'name' => 'Quarry'
                ],
                'code' => 'quarry'
            ],
            [
                'es' => [
                    'name' => 'Cedido'
                ],
                'en' => [
                    'name' => 'Yielded'
                ],
                'code' => 'yielded'
            ],
            [
                'es' => [
                    'name' => 'Compra'
                ],
                'en' => [
                    'name' => 'Buy'
                ],
                'code' => 'buy'
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
        $this->createClubArrivalType($this->get()->current());
    }
}
