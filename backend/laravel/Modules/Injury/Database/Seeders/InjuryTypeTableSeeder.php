<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\InjuryTypeRepositoryInterface;

class InjuryTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $injuryTypeRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(InjuryTypeRepositoryInterface $injuryTypeRepository)
    {
        $this->injuryTypeRepository = $injuryTypeRepository;
    }

    /**
     * @return void
     */
    protected function createInjuryType(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->injuryTypeRepository->create($elm);
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
                    'name' => 'Traumática'
                ],
                'en' => [
                    'name' => 'Traumatic'
                ],
                'code' => 'traumatic_injury'
            ],
            [
                'es' => [
                    'name' => 'Sobreuso'
                ],
                'en' => [
                    'name' => 'Overuse'
                ],
                'code' => 'overuse_injury'
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
        $this->createInjuryType($this->get()->current());
    }
}
