<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
{
     /**
     * @OA\Schema(
     *   schema="StoreUnitRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="type name in spanish ", format="string", example="Kilogramo" ),
     *   @OA\Property( title="Name in English", property="name_english", description="type name in English", format="string", example="kilogram" ),
     *   @OA\Property( title="Code", property="code", description="Code to indentify", format="string", example="kg" ),     * )
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
            'code' => 'required'
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
