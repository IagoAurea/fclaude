<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestSubTypeRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateTestSubTypeRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="type name in spanish ", format="string", example="Especial dos" ),
     *   @OA\Property( title="Name in English", property="name_english", description="type name in English", format="string", example="Special two" ),
     *   @OA\Property( title="Test Type", property="test_type_id", description="type related", format="integer", example="1" ), 
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
            'test_type_id' => 'required|integer|exists:test_types,id',
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
