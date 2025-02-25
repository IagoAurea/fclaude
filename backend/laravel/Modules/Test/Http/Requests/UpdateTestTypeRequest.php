<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestTypeRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateTestTypeRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="type name in spanish ", format="string", example="Especial dos" ),
     *   @OA\Property( title="Name in English", property="name_english", description="type name in English", format="string", example="Special two" ),
     *   @OA\Property( title="Classification", property="classification", description="If is for RFD (1), tests (2) or both (3)", format="integer", example="3" ),
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
            'classification' => 'required|integer|min:1|max:3',
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
