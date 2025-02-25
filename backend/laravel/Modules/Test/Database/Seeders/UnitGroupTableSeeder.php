<?php

namespace Modules\Test\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Test\Repositories\Interfaces\UnitGroupRepositoryInterface;
use Modules\Test\Repositories\Interfaces\UnitRepositoryInterface;

class UnitGroupTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $unitRepository;

    /**
     * @var object
     */
    protected $unitGroupRepository;

    public function __construct(
        UnitGroupRepositoryInterface $unitGroupRepository,
        UnitRepositoryInterface $unitRepository
    ) {
        $this->unitRepository = $unitRepository;
        $this->unitGroupRepository = $unitGroupRepository;
    }

    /**
     * @return void
     */
    protected function createUnitGroup(array $elements)
    {
        foreach ($elements as $elm) {
            $this->unitGroupRepository->create($elm);
        }
    }

    /**
     * @return \Iterator
     */
    private function get()
    {
        yield [
            [
                'code' => 'weight',
                'unit_id' => $this->unitRepository->findOneBy(['code' => 'kg'])->id
            ],
            [
                'code' => 'weight',
                'unit_id' => $this->unitRepository->findOneBy(['code' => 'lb'])->id
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
        $this->createUnitGroup($this->get()->current());
    }
}
