<?php

namespace Modules\Player\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillsRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreSkillsRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="type name in spanish ", format="string", example="skill dos" ),
     *   @OA\Property( title="Name in English", property="name_english", description="type name in English", format="string", example="skill two" ),
     *   @OA\Property( title="Code", property="code", description="Code to indentify", format="string", example="skill" ),     
     *   @OA\Property( title="Image", property="image", description="image", format="file", example="" ),     
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048'
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
