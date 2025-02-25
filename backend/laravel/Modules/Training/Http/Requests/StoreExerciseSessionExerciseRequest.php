<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseSessionExerciseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     *
     * @OA\Schema(
     *  schema="StoreExerciseSessionExerciseRequest",
     *  @OA\Property(
     *      title="Exercise session ",
     *      property="exercise_session_id",
     *      description="session associate",
     *      format="integer",
     *      example="1" ),
     *  @OA\Property(
     *      title="exercises",
     *      property="exercises",
     *      description="exercises",
     *      format="application/json",
     *      example="[{'exercise_id': 5,'work_groups':  [],'duration': '20:25','repetitions':8,'duration_repetitions':'01:00','break_repetitions':'00:05','series': 1,'break_series':'01:00'}]" ),
     * )
     */
    public function rules()
    {
        return [
            'exercise_session_id' => 'required|integer|exists:exercise_sessions,id',
            'exercises' => 'required|array',
            'exercises.*.exercise_id' => 'required|integer|exists:exercises,id',
            'exercises.*.work_groups' => 'array',
            'exercises.*.duration' => 'string',
            'exercises.*.repetitions' => 'nullable|integer',
            'exercises.*.duration_repetitions' => 'nullable|string',
            'exercises.*.break_repetitions' => 'nullable|string',
            'exercises.*.series' => 'integer',
            'exercises.*.break_series' => 'nullable|string',
            'exercises.*.difficulty' => 'integer',
            'exercises.*.intensity' => 'integer',
            'exercises.*.order' => 'integer'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
