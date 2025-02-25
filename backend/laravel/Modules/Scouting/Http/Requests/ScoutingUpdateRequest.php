<?php

namespace Modules\Scouting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoutingUpdateRequest extends FormRequest
{
    /**
     *  @OA\Schema(
     *      schema="ScoutingUpdateRequest",
     *      @OA\Property(title="Time real scouting", property="in_real_time", description="time real scouting", format="string", example="283"),
     *      @OA\Property(title="Start match scouting", property="start_match", description="start match scouting (L for Local or V for Visit)", format="string", example="L"),
     *      @OA\Property(title="Number sets for Tennis", property="sets", description="sets tennis scouting", format="integer", example="3"),
     *  )
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'in_real_time' => 'nullable|integer',
            'start_match' => 'nullable|string|max:1',
            'sets' => 'nullable|integer'
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
