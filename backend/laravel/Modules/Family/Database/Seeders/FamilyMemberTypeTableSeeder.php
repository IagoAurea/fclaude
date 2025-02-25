<?php

namespace Modules\Family\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Family\Repositories\Interfaces\FamilyMemberTypeRepositoryInterface;

class FamilyMemberTypeTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $familyMemberTypeRepository;

    public function __construct(FamilyMemberTypeRepositoryInterface $familyMemberTypeRepository)
    {
        $this->familyMemberTypeRepository = $familyMemberTypeRepository;
    }

    /**
     * @return void
     */
    protected function createFamilyMemberTypes(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->familyMemberTypeRepository->create($elm);
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
                    'name' => 'Madre'
                ],
                'en' => [
                    'name' => 'Mother'
                ],
                'code' => 'mother'
            ],
            [
                'es' => [
                    'name' => 'Padre'
                ],
                'en' => [
                    'name' => 'Father'
                ],
                'code' => 'father'
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
        $this->createFamilyMemberTypes($this->get()->current());
    }
}