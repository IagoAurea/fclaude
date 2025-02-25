<?php

namespace Modules\Injury\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Injury\Repositories\Interfaces\InjurySeverityRepositoryInterface;

class InjurySeverityTableSeeder extends Seeder
{
    /**
     * @var object
     */
    protected $injurySeverityRepository;

    /**
     * Create a seeder instance
     */
    public function __construct(InjurySeverityRepositoryInterface $injurySeverityRepository)
    {
        $this->injurySeverityRepository = $injurySeverityRepository;
    }

    /**
     * @return void
     */
    protected function createInjurySeverity(array $elements)
    {
        foreach($elements as $elm)
        {
            $this->injurySeverityRepository->create($elm);
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
                    'name' => 'Mínima (de 1 a 3 días)'
                ],
                'en' => [
                    'name' => 'Minimum (from 1 to 3 days)'
                ],
                'code' => 'severity_minimum',
                'min' => 1,
                'max' => 3
            ],
            [
                'es' => [
                    'name' => 'Leve (de 4 a 7 días)'
                ],
                'en' => [
                    'name' => 'Mild (from 4 to 7 days)'
                ],
                'code' => 'severity_mild',
                'min' => 4,
                'max' => 7
            ],
            [
                'es' => [
                    'name' => 'Moderada (de 8 a 28 días)'
                ],
                'en' => [
                    'name' => 'Moderate (from 8 to 28 days)'
                ],
                'code' => 'severity_moderate',
                'min' => 8,
                'max' => 28
            ],
            [
                'es' => [
                    'name' => 'Grave (más de 28 días)'
                ],
                'en' => [
                    'name' => 'Serious (more than 28 days)'
                ],
                'code' => 'severity_serious',
                'min' => 28,
                'max' => null
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
        $this->createInjurySeverity($this->get()->current());
    }
}
