<?php

namespace Modules\Competition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerceptEffortPlayerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 
     *  *  @OA\Schema(
     *      schema="PerceptEffortPlayerRequest",
     *      @OA\Property(title="Player", property="player_id", description="player", format="int64", example="1"),
     *      @OA\Property(title="Perception Effort", property="perception_effort_id", description="perception effort", format="int64", example="1")
     *  )
     */
    public function rules()
    {
        return [
            'player_id' => 'required|integer|exists:players,id',
            'perception_effort_id' => 'required|integer|exists:subjec_percept_efforts,id'
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
