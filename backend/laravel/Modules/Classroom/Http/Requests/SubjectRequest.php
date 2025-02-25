<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *   schema="SubjectRequest",
 *   @OA\Property( title="Name in Spanish", property="name_spanish", description="category name in spanish ", format="string", example="Nueva Fase" ),
 *   @OA\Property( title="Name in English", property="name_english", description="category name in English", format="string", example="New Phase" ),
 *   @OA\Property( title="Code", property="code", description="code to identify", format="string", example="new" ),
 *   @OA\Property( title="Image", property="image", description="image by team", format="file", example="" )
 *   )
 */
class SubjectRequest extends FormRequest
{
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
            'code'         => 'required',
            'image_id'     => 'sometimes|image|mimes:jpeg,png,jpg,svg|min:1|max:2048'
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
