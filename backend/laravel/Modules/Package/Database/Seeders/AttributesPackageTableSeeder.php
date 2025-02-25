<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Repositories\Interfaces\PackageRepositoryInterface;
use Modules\Package\Repositories\Interfaces\AttributePackRepositoryInterface;

class AttributesPackageTableSeeder extends Seeder
{
    /** 
     * @var object
     */
    protected $packageRepository;

    /**
     * @var object
     */
    protected $attributePackRepository;

    public function __construct(
        PackageRepositoryInterface $packageRepository, 
        AttributePackRepositoryInterface $attributePackRepository
    )
    {
        $this->packageRepository = $packageRepository;
        $this->attributePackRepository = $attributePackRepository;
    }

    /**
     * @return void
     */
    protected function createAttributesPackage(array $elements)
    {
        $packages = $this->packageRepository->findAll();

        $attributes = $this->attributePackRepository->findAll()->toArray();

        foreach($packages as $elm) 
        {
            $package = $elements[array_search($elm->code, array_column($elements, 'code'))];

            foreach($package['attributes'] as $val) 
            {
                $attribute = $attributes[array_search($val['code'], array_column($attributes, 'code'))];

                $elm->attributes()->attach($attribute['id']);
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
                'code' => 'sport',
                'attributes' => [
                    [ 'code' => 'seasons' ],
                    [ 'code' => 'teams' ],
                    [ 'code' => 'users' ],
                    [ 'code' => 'competition'],
                    [ 'code' => 'matches' ],
                    [ 'code' => 'scouting' ],
                    [ 'code' => 'exercise_design' ],
                    [ 'code' => 'training_sessions' ],
                    [ 'code' => 'players'],
                    [ 'code' => 'test' ],
                    [ 'code' => 'injury_prevention' ],
                    [ 'code' => 'rfd_injuries' ],
                    [ 'code' => 'fisiotherapy' ],
                    [ 'code' => 'recovery_exertion' ],
                    [ 'code' => 'nutrition' ],
                    [ 'code' => 'psychology_reports' ]
                ]
            ],
            [
                'code' => 'teacher',
                'attributes' => [
                    [ 'code' => 'school' ],
                    [ 'code' => 'classes' ],
                    [ 'code' => 'students' ],
                    [ 'code' => 'exercise_design' ],
                    [ 'code' => 'training_sessions' ],
                    [ 'code' => 'scenarios' ],
                    [ 'code' => 'test' ],
                    [ 'code' => 'rubrics' ],
                    [ 'code' => 'evaluations' ],
                    [ 'code' => 'tutorials' ],
                    [ 'code' => 'ratings'],
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
        $this->createAttributesPackage($this->get()->current());
    }
}
