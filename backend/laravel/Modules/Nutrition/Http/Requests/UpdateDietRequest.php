<?php

namespace Modules\Nutrition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDietRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateDietRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="category name in spanish ", format="string", example="Nueva criterio" ),
     *   @OA\Property( title="Name in English", property="name_english", description="category name in English", format="string", example="New criterion" ),
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
