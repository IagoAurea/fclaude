<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\InjurySituationRepositoryInterface;

class InjurySituationTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $injurySituationRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(InjurySituationRepositoryInterface $injurySituationRepository)
    {
        $this->injurySituationRepository = $injurySituationRepository;
    }

    /**
     * @return void
     */
    protected function createInjurySituation(array $elements)
    {
        foreach ($elements as $elm) {
            $this->injurySituationRepository->create($elm);
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
                    'name' => 'Entrenamiento'
                ],
                'en' => [
                    'name' => 'Training'
                ],
                'code' => 'training'
            ],
            [
                'es' => [
                    'name' => 'Competición'
                ],
                'en' => [
                    'name' => 'Competition'
                ],
                'code' => 'competition'
            ],
            [
                'es' => [
                    'name' => 'Otros'
                ],
                'en' => [
                    'name' => 'Others'
                ],
                'code' => 'others'
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
        $this->createInjurySituation($this->get()->current());
    }
}
