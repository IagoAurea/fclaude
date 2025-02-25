<?php

namespace Modules\Nutrition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAthleteActivityRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreAthleteActivityRequest",
     *    @OA\Property( title="Repose", property="repose", description="number of hours at repose", format="double", example="6" ),
     *    @OA\Property( title="Very light", property="very_light", description="number of hours at", format="double", example="5" ),     
     *    @OA\Property( title="Light", property="light", description="number of hours at", format="double", example="5" ),     
     *    @OA\Property( title="Moderate", property="moderate", description="number of hours at", format="double", example="5" ),    
     *    @OA\Property( title="Intense", property="intense", description="number of hours at", format="double", example="3" ),    
     *    @OA\Property( title="Player", property="nutritional_sheet_id", description="Nutritional Sheet Associate", format="integer", example="1" )    
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
            'repose' => 'required|numeric',
            'very_light' => 'required|numeric',
            'light' => 'required|numeric',
            'moderate' => 'required|numeric',
            'intense' => 'required|numeric',
            'nutritional_sheet_id' => 'required|integer',
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
