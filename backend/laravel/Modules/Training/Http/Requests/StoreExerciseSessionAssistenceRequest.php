<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseSessionAssistenceRequest extends FormRequest
{

    /**
     * @OA\Schema(
     *   schema="StoreExerciseSessionAssistenceRequest",
     *   @OA\Property( title="Exercise session ", property="exercise_session_id", description="session associate", format="integer", example="1" ),
     *   @OA\Property( title="Assistance", property="assistances", description="assistances", format="application/json", example="[{'assistance':  1,'player_id':1, perception_effort_id: 1},{'assistance':  1,'alumn_id':2, perception_effort_id: 3}]" ),
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
            'assistances.*.assistance' => 'required|boolean',
            'assistances.*.player_id' => 'required_without:assistances.*.alumn_id|integer|exists:players,id',
            'assistances.*.alumn_id' => 'required_without:assistances.*.player_id|integer|exists:alumns,id',
            'assistances.*.perception_effort_id' => 'nullable|integer|exists:subjec_percept_efforts,id',
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
