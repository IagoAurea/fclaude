<?php

namespace Modules\Package\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Repositories\Interfaces\SubpackageRepositoryInterface;
use Modules\Package\Repositories\Interfaces\AttributePackRepositoryInterface;

class AttributesSubpackageTableSeeder extends Seeder
{
    /** 
     * @var object
     */
    protected $subpackageRepository;

    /**
     * @var object
     */
    protected $attributePackRepository;

    public function __construct(
        SubpackageRepositoryInterface $subpackageRepository, 
        AttributePackRepositoryInterface $attributePackRepository
    )
    {
        $this->subpackageRepository = $subpackageRepository;
        $this->attributePackRepository = $attributePackRepository;
    }

    /**
     * @return void
     */
    protected function createAttributesSubpackage(array $elements)
    {
        $subpackages = $this->subpackageRepository->findAll();

        $attributes = $this->attributePackRepository->findAll()->toArray();

        foreach($subpackages as $elm) 
        {
            $subpackage = $elements[array_search($elm->code, array_column($elements, 'code'))];

            foreach($subpackage['attributes'] as $val) 
            {
                $attribute = $attributes[array_search($val['code'], array_column($attributes, 'code'))];

                $elm->attributes()->attach($attribute['id'], [
                    'quantity' => isset($val['quantity']) ? $val['quantity']: null,
                    'available' => isset($val['available']) ? (bool) $val['available']: true
                ]);
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
                'code' => 'sport_bronze',
                'attributes' => [
                    [ 'code' => 'clubs' ],
                    [ 'code' => 'teams', 'quantity' => 1 ],
                    [ 'code' => 'competition'],
                    [ 'code' => 'matches', 'quantity' => 50 ],
                    [ 'code' => 'scouting' ],
                    [ 'code' => 'exercise_design', 'quantity' => 100 ],
                    [ 'code' => 'training_sessions', 'quantity' => 150 ],
                    [ 'code' => 'players', 'quantity' => 30 ],
                    [ 'code' => 'test', 'quantity' => 200 ],
                    [ 'code' => 'injury_prevention', 'quantity' => 60 ],
                    [ 'code' => 'rfd_injuries', 'quantity' => 60  ],
                    [ 'code' => 'fisiotherapy', 'quantity' => 60 ],
                    [ 'code' => 'recovery_exertion', 'quantity' => 60],
                    [ 'code' => 'nutrition', 'quantity' => 60],
                    [ 'code' => 'psychology_reports', 'quantity' => 60 ]
                ]
            ],
            [
                'code' => 'sport_silver',
                'attributes' => [
                    [ 'code' => 'clubs' ],
                    [ 'code' => 'teams', 'quantity' => 3 ],
                    [ 'code' => 'competition'],
                    [ 'code' => 'matches', 'quantity' => 75 ],
                    [ 'code' => 'scouting' ],
                    [ 'code' => 'exercise_design', 'quantity' => 150 ],
                    [ 'code' => 'training_sessions', 'quantity' => 200 ],
                    [ 'code' => 'players', 'quantity' => 40 ],
                    [ 'code' => 'test', 'quantity' => 300 ],
                    [ 'code' => 'injury_prevention', 'quantity' => 120 ],
                    [ 'code' => 'rfd_injuries', 'quantity' => 120  ],
                    [ 'code' => 'fisiotherapy', 'quantity' => 120 ],
                    [ 'code' => 'recovery_exertion', 'quantity' => 120],
                    [ 'code' => 'nutrition', 'quantity' => 120],
                    [ 'code' => 'psychology_reports', 'quantity' => 120 ]
                ]
            ],
            [
                'code' => 'sport_gold',
                'attributes' => [
                    [ 'code' => 'clubs' ],
                    [ 'code' => 'teams', 'quantity' => 6 ],
                    [ 'code' => 'competition'],
                    [ 'code' => 'matches', 'quantity' => 100 ],
                    [ 'code' => 'scouting' ],
                    [ 'code' => 'exercise_design', 'quantity' => 200 ],
                    [ 'code' => 'training_sessions', 'quantity' => 300 ],
                    [ 'code' => 'players', 'quantity' => 50 ],
                    [ 'code' => 'test', 'quantity' => 400 ],
                    [ 'code' => 'injury_prevention', 'quantity' => 200 ],
                    [ 'code' => 'rfd_injuries', 'quantity' => 200  ],
                    [ 'code' => 'fisiotherapy', 'quantity' => 200 ],
                    [ 'code' => 'recovery_exertion', 'quantity' => 200],
                    [ 'code' => 'nutrition', 'quantity' => 200],
                    [ 'code' => 'psychology_reports', 'quantity' => 200 ]
                ]
            ],
            [
                'code' => 'teacher_bronze',
                'attributes' => [
                    [ 'code' => 'school' ],
                    [ 'code' => 'classes' ],
                    [ 'code' => 'students' ],
                    [ 'code' => 'exercise_design', 'quantity' => 150 ],
                    [ 'code' => 'training_sessions', 'quantity' => 200 ],
                    [ 'code' => 'scenarios', 'quantity' => 1 ],
                    [ 'code' => 'test', 'quantity' => 200 ],
                    [ 'code' => 'rubrics', 'quantity' => 100 ],
                    [ 'code' => 'evaluations', 'quantity' =>600  ],
                    [ 'code' => 'tutorials', 'quantity' => 100 ],
                    [ 'code' => 'ratings'],
                ]
            ],
            [
                'code' => 'teacher_silver',
                'attributes' => [
                    [ 'code' => 'school' ],
                    [ 'code' => 'classes' ],
                    [ 'code' => 'students' ],
                    [ 'code' => 'exercise_design', 'quantity' => 200 ],
                    [ 'code' => 'training_sessions', 'quantity' => 300 ],
                    [ 'code' => 'scenarios', 'quantity' => 3 ],
                    [ 'code' => 'test', 'quantity' => 300 ],
                    [ 'code' => 'rubrics', 'quantity' => 100 ],
                    [ 'code' => 'evaluations', 'quantity' => 600 ],
                    [ 'code' => 'tutorials', 'quantity' => 150 ],
                    [ 'code' => 'ratings'],
                ]
            ],
            [
                'code' => 'teacher_gold',
                'attributes' => [
                    [ 'code' => 'school' ],
                    [ 'code' => 'classes' ],
                    [ 'code' => 'students' ],
                    [ 'code' => 'exercise_design', 'quantity' => 1250 ],
                    [ 'code' => 'training_sessions', 'quantity' => 400 ],
                    [ 'code' => 'scenarios', 'quantity' => 5 ],
                    [ 'code' => 'test', 'quantity' => 400 ],
                    [ 'code' => 'rubrics', 'quantity' => 100 ],
                    [ 'code' => 'evaluations', 'quantity' => 600 ],
                    [ 'code' => 'tutorials', 'quantity' => 200 ],
                    [ 'code' => 'ratings'],
                ]
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
        $this->createAttributesSubpackage($this->get()->current());
    }
}
