<?php

namespace Modules\Evaluation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Evaluation\Entities\EvaluationGrade;

class EvaluationGradeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EvaluationGrade::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'player_id' => 1,
            'classroom_academic_year_id' => 1,
            'indicator_rubric_id' => 1,
            'grade' => 10
        ];
    }
}
