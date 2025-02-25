<?php

namespace Modules\Competition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Competition\Repositories\Interfaces\TestCategoryMatchRepositoryInterface;

class TestCategoriesMatchTableSeeder extends Seeder
{
    /**
     * repository
     * @var $testCategoryMatchRepository
     */
    protected $testCategoryMatchRepository;

    /**
     * TestCategoriesMatchTableSeeder constructor.
     * @param TestCategoryMatchRepositoryInterface $testCategoryMatchRepository
     */
    public function __construct(TestCategoryMatchRepositoryInterface $testCategoryMatchRepository)
    {
        $this->testCategoryMatchRepository = $testCategoryMatchRepository;
    }

    /**
     * Method create test cateogy match
     * @param array $elements
     * @return void
     */
    protected function createTestCategoryMatch($elements)
    {
        foreach ($elements as $element)
        {
            $this->testCategoryMatchRepository->create($element);
        }
    }

    /**
     * @return \Generator
     */
    private function get()
    {
        yield [
            [
                'es' => [ 'name' => 'Estilo libre'],
                'en' => [ 'name' => 'Freestyle'],
                'code' => 'freestyle'
            ],
            [
                'es' => [ 'name' => 'Espalda'],
                'en' => [ 'name' => 'Backstroke'],
                'code' => 'backstroke'
            ],
            [
                'es' => [ 'name' => 'Braza'],
                'en' => [ 'name' => 'Breaststroke'],
                'code' => 'breaststroke'
            ],
            [
                'es' => [ 'name' => 'Mariposa'],
                'en' => [ 'name' => 'Butterfly'],
                'code' => 'butterfly'
            ],
            [
                'es' => [ 'name' => 'Estilos individual'],
                'en' => [ 'name' => 'Individual medley'],
                'code' => 'individual_medley'
            ],
            [
                'es' => [ 'name' => 'Relevos libre'],
                'en' => [ 'name' => 'Freestyle relay'],
                'code' => 'freestyle_relay'
            ],
            [
                'es' => [ 'name' => 'Relevos estilos'],
                'en' => [ 'name' => 'Medley relay'],
                'code' => 'medley_relay'
            ],
            [
                'es' => [ 'name' => 'Relevos mixtos'],
                'en' => [ 'name' => 'Mixed relay'],
                'code' => 'mixed_relay'
            ]
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTestCategoryMatch($this->get()->current());
    }
}
