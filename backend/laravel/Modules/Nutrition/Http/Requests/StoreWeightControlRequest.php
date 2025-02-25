<?php

namespace Modules\Nutrition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeightControlRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreWeightControlRequest",
     *   @OA\Property( title="Weight", property="weight", description="weight", format="decimal", example="80.5" ),
     *   @OA\Property( title="Player", property="player_id", description="player associate", format="integer", example="1" ),
     *   @OA\Property( title="Team", property="team_id", description="Team associate", format="integer", example="1" ),
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
            'weight' => 'required|numeric|max:999',
            'player_id' => 'required|integer',
            'team_id' => 'required|integer'
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
