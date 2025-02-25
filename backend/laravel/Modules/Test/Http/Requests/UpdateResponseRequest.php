<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResponseRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateResponseRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="category name in spanish ", format="string", example="Bueno" ),
     *   @OA\Property( title="Name in English", property="name_english", description="category name in English", format="string", example="Good" ),
     *   @OA\Property( title="Tooltick", property="tooltick", description="tooltick by response", format="string", example="this is a tooltick text"  ), * )
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
            'tooltick' => 'nullable|string',
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
