<?php

namespace Modules\Player\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePunctuationRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StorePunctuationRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="type name in spanish ", format="string", example="punctuation dos" ),
     *   @OA\Property( title="Name in English", property="name_english", description="type name in English", format="string", example="punctuation two" ),
     *   @OA\Property( title="Code", property="code", description="Code to indentify", format="string", example="punctuation" ),     
     *   @OA\Property( title="Value", property="value", description="value", format="double", example="5.5" ),
     *   @OA\Property( title="Color", property="color", description="color", format="string", example="#FB6B26" ),
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
            'code' => 'required',
            'value' =>  'required|numeric',
            'color' => 'nullable|regex:/^#([A-Fa-f0-9]{6})$/',
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
