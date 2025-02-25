<?php

namespace Modules\Competition\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Competition\Repositories\Interfaces\TestCategoryMatchRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\TestTypeCategoryMatchRepositoryInterface;

class TestTypeCategoriesMatchTableSeeder extends Seeder
{   
    /**
     * @var $testCategoryMatchRepository
     */
    protected $testCategoryMatchRepository;

    /**
     * @var $testTypeCategoryMatchRepository
     */
    protected $testTypeCategoryMatchRepository;

    /**
     * TestCategoriesMatchTableSeeder constructor.
     * @param TestCategoryMatchRepositoryInterface $testCategoryMatchRepository
     */
    public function __construct(
        TestCategoryMatchRepositoryInterface $testCategoryMatchRepository,
        TestTypeCategoryMatchRepositoryInterface $testTypeCategoryMatchRepository
    )
    {
        $this->testCategoryMatchRepository = $testCategoryMatchRepository;
        $this->testTypeCategoryMatchRepository = $testTypeCategoryMatchRepository;
    }

    /**
     * Method create test type cateogy match
     * @return void
     */
    public function createTestTypeCategoryMatch() 
    {
        $type_categories = $this->getTestTypeCategoriesMatch();

        foreach($type_categories as $category => $types) {
            $test_category = $this->testCategoryMatchRepository->findOneBy(['code' => $category]);

            $fields = [];

            foreach($types as $type) {
                $this->testTypeCategoryMatchRepository->create([
                    'type' => $type,
                    'test_category_match_id' => $test_category->id
                ]);
            }

        }
    }

    /**
     * @return Array
     */
    private function getTestTypeCategoriesMatch()
    {
        return [
            'freestyle' => ["50 m", "100 m", "200 m", "400 m", "800 m", "1500 m"],
            'backstroke' => ["50 m", "100 m", "200 m"],
            'breaststroke' => ["50 m", "100 m", "200 m"],
            'butterfly' => ["50 m", "100 m"],
            'individual_medley' => ["100 m", "200 m", "400 m"],
            'freestyle_relay' => ["4 x 50 m", "4 x 100 m", "4 x 200 m"],
            'medley_relay' => ["4 x 50 m", "4 x 100 m"],
            'mixed_relay' => ["4 x 50 freestyle (libre) - 4 x 50 m medley (estilos)"]
        ];
    }
        
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createTestTypeCategoryMatch();
    }
}
