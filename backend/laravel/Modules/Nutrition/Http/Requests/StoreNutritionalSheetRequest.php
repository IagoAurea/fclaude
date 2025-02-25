<?php

namespace Modules\Nutrition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNutritionalSheetRequest extends FormRequest
{

    /**
     * @OA\Schema(
     *   schema="StoreNutritionalSheetRequest",
     *      @OA\Property( title="Take Supplements", property="take_supplements", description="if take supplements", format="boolean", example="true" ),
     *      @OA\Property( title="Take Diet", property="take_diets", description="if take diets", format="boolean", example="true" ),
     *      @OA\Property( title="Activity Factor", property="activity_factor", description="calculate activity factor", format="decimal", example="15.5" ) ,
     *      @OA\Property( title="Total Energy Expendidure", property="total_energy_expenditure", description="calculate", format="decimal", example="20.3" ) ,
     *      @OA\Property( title="Other Supplement", property="other_supplement", description="name", format="string", example="Supplement New" ) ,
     *      @OA\Property( title="Other Diet", property="other_diet", description="name", format="string", example="Diet New" ), 
     *      @OA\Property( title="Player", property="player_id", description="Player associate", format="integer", example="1" ),
     *      @OA\Property( title="Team", property="team_id", description="Team associate", format="integer", example="1" ),
     *      @OA\Property( title="Diets", property="diets", description="diets associate", format="array", example="[1,2,3]" ),
     *      @OA\Property( title="Supplements", property="supplements", description="supplements associate", format="array", example="[1,2,3]" ),
     *      @OA\Property( title="Athlete Activity", property="athlete_activity", description="hours athlete activity", format="application/json", example="{'repose':5,'very_light':5,'light':5,'moderate':5,'intense':4}" ),
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
            'take_supplements' => 'required|bool',
            'take_diets' => 'required|bool',
            'activity_factor' => 'required|numeric',
            'player_id' => 'required|integer',
            'team_id' => 'required|integer|exists:teams,id'

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
