<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseSessionDetailRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreExerciseSessionDetailRequest",
     *   @OA\Property( title="Exercise session", property="exercise_session_id", description="session associate", format="integer", example="1" ),
     *   @OA\Property( title="Date Session", property="date_session", description="date to session", format="date", example="2021-11-10" ),
     *   @OA\Property( title="Hour Session", property="hour_session", description="hour to session", format="string", example="05:00" ),
     *   @OA\Property( title="Place Session", property="place_session", description="place to session", format="string", example="place" ),
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
            'exercise_session_id' => 'required|integer|exists:exercise_sessions,id',
            'date_session' => 'required|date',
            'hour_session' => 'required|string|max:5',
            'place_session' => 'required|string|max:255',
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
