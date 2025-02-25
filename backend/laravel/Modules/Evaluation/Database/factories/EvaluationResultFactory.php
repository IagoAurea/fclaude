<?php

namespace Modules\Evaluation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Evaluation\Entities\EvaluationResult;

class EvaluationResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EvaluationResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'alumn_id' => 1,
            'classroom_academic_year_id' => 1,
            'evaluation_rubric_id' => 1,
            'user_id' => 1,
            'status' => EvaluationResult::STATUS_NOT_EVALUATED,
            'evaluation_grade' => 0,
            'qualification_grade' => 0
        ];
    }
}
