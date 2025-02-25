<?php

namespace Modules\Injury\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhaseRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdatePhaseRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="category name in spanish ", format="string", example="Nueva Fase" ),
     *   @OA\Property( title="Name in English", property="name_english", description="category name in English", format="string", example="New Phase" ),
     *   @OA\Property( title="Test code", property="test_code", description="test code identify", format="string", example="retraining" ),     
     *   @OA\Property( title="Percentage Value", property="percentage_value", description="phase value", format="double", example="84.99" ),
     *   @OA\Property( title="Min Percentage Passed", property="min_percentage_pass", description="phase value", format="double", example="84.99" )
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
            'test_code'    => 'required|exists:tests,code',
            'percentage_value' => 'required|numeric',
            'min_percentage_pass'  => 'required|numeric'
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
