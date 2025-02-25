<?php

namespace Modules\Scouting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoutingResultStoreRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *      schema="ScoutingResultStoreRequest",
     *      @OA\Property(title="Time game scouting", property="in_game_time", description="time game scouting", format="integer", example="283"),
     *      @OA\Property(title="Data scouting", property="scouting", description="data score stastic scouting", format="object", example="object"),
     *  )
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'scouting' => 'required',
            'in_game_time' => 'required|integer'
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
