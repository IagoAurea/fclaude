<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseSessionLikeRequest extends FormRequest
{

    /**
     * @OA\Schema(
     *   schema="StoreExerciseSessionLikeRequest",
     *   @OA\Property( title="Exercise session", property="exercise_session_id", description="session associate", format="integer", example="1" ),
     * * )
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exercise_session_id' => 'required|integer|exists:exercise_sessions,id'
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
