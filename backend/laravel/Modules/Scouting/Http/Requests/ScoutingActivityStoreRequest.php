<?php

namespace Modules\Scouting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoutingActivityStoreRequest extends FormRequest
{
    /**
     *  @OA\Schema(
     *  schema="ScoutingActivityStoreRequest",
     *  type="object",
     *  required={
     *      "action_id",
     *      "in_game_time"
     *  },
     * @OA\Property(property="action_id", format="int64", example="1"),
     * @OA\Property(property="in_game_time", format="int", example="10"),
     * @OA\Property(property="player_id", format="int64", example="1"),
     * @OA\Property(property="status", format="boolean", example="false"),
     * )
     * 
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action_id' => 'integer|required',
            'in_game_time' => 'integer|required',
            'player_id' => 'numeric',
            'status' => 'boolean',
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
