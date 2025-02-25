<?php

namespace Modules\Player\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillsRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateSkillsRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="type name in spanish ", format="string", example="skill dos" ),
     *   @OA\Property( title="Name in English", property="name_english", description="type name in English", format="string", example="skill two" ),
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
