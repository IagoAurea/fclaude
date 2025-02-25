<?php

namespace Modules\Generality\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Generality\Repositories\Interfaces\KinshipRepositoryInterface;

class KinshipsTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $kinshipRepository;

    public function __construct(KinshipRepositoryInterface $kinshipRepository)
    {
        $this->kinshipRepository = $kinshipRepository;
    }

    /**
     * @return void
     */
    protected function createKinship(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->kinshipRepository->create($elm);
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
                    'name' => 'Soltero'
                ],
                'en' => [
                    'name' => 'Single'
                ],
                'code' => 'single'
            ],
            [
                'es' => [
                    'name' => 'Casado'
                ],
                'en' => [
                    'name' => 'Married'
                ],
                'code' => 'married'
            ],
            [
                'es' => [
                    'name' => 'Divorciado'
                ],
                'en' => [
                    'name' => 'Divorced'
                ],
                'code' => 'divorced'
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
        $this->createKinship($this->get()->current());
    }
}
