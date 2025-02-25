<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateTestRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="category name in spanish ", format="string", example="Bueno " ),
     *   @OA\Property( title="Name in English", property="name_english", description="category name in English", format="string", example="Good" ),
     *   @OA\Property( title="Test Type", property="test_type_id", description="Test Type ", format="integer", example="1" ),
     *   @OA\Property( title="Value", property="value", description="test value in percentage or points", format="double", example="100" ),
     *   @OA\Property( title="Image", property="image", description="the related image", format="image", example="" ),
     *   @OA\Property( title="Type Valoration", property="type_valoration_code", description="Defines if the test is evaluated by points or by percentage", format="string", example="percentage" ),
     *   @OA\Property( title="Sport", property="sport_id", description="id to sport to relate test", format="integer", example="1" ),
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
            'name_spanish'         => 'required|string',
            'name_english'         => 'required|string',
            'test_type_id'         => 'required|exists:test_types,id' ,
            'type_valoration_code' => 'required|string|exists:type_valorations,code',
            'value'                => 'required|numeric',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,svg|dimensions:min_width=250,min_height=250|min:1|max:2048',
            'sport_id'             => 'nullable|integer|exists:sports,id'  
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
