<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseSessionExerciseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 
     *  @OA\Schema(
     *      schema="UpdateExerciseSessionExerciseRequest",
     *      @OA\Property(title="Duration", property="duration", description="Duration", format="string", example="10:12" ),
     *      @OA\Property(title="Repetitions", property="repetitions", description="Repetitions", format="integer", example="1" ),
     *      @OA\Property(title="Durations Repetitions", property="duration_repetitions", description="Duration Repetitions", format="string", example="12:12" ),
     *      @OA\Property(title="Break Repetitions", property="break_repetitions", description="Break Repetitions", format="string", example="12:12" ),
     *      @OA\Property(title="Series", property="series", description="Series", format="integer", example="1" ),
     *      @OA\Property(title="Break Series", property="break_series", description="Break Series", format="string", example="12:12" ),
     *      @OA\Property(title="Difficulty", property="difficulty", description="Series", format="integer", example="1" ),
     *      @OA\Property(title="Intensity", property="intensity", description="Intensity", format="integer", example="1" )
     *  )
     */
    public function rules()
    {
        return [
            'duration' => 'string|max:5|min:5|regex:/^\d{2}:\d{2}$/',
            'repetitions' => 'integer',
            'duration_repetitions' => 'string|max:5|min:5|regex:/^\d{2}:\d{2}$/',
            'break_repetitions' => 'string|max:5|min:5|regex:/^\d{2}:\d{2}$/',
            'series' => 'integer',
            'break_series' => 'string|max:5|min:5|regex:/^\d{2}:\d{2}$/',
            'difficulty' => 'integer',
            'intensity' => 'integer',
            'order' => 'integer'
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
