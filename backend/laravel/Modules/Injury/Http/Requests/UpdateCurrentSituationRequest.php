<?php

namespace Modules\Injury\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrentSituationRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateCurrentSituationRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="category name in spanish ", format="string", example="Nueva situación" ),
     *   @OA\Property( title="Name in English", property="name_english", description="category name in English", format="string", example="New situation" ),
     *   @OA\Property( title="Color", property="color", description="color to status", format="string", example="#fffff" ),     
     *   @OA\Property( title="Min Percentage", property="min_percentage", description="lower limit for status", format="double", example="84,99" ),     
     *   @OA\Property( title="Max Percentage", property="max_percentage", description="upper limit for state", format="double", example="100" )    
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
            'name_spanish' => 'required|string',
            'name_english' => 'required|string',
            'color'          => 'required|regex:/^#([A-Fa-f0-9]{6})$/',
            'min_percentage' => 'required|numeric',
            'max_percentage' => 'required|numeric',
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
