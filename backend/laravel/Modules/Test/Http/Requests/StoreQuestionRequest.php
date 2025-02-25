<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
     /**
     * @OA\Schema(
     *   schema="StoreQuestionRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="category name in spanish ", format="string", example="¿ Cúal es tu nombre ? " ),
     *   @OA\Property( title="Name in English", property="name_english", description="category name in English", format="string", example="what's your name ?" ),
     *   @OA\Property( title="Question Category Code", property="question_category_code", description="Category", format="string", example="physical_abilities" ),     * )
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
            'question_category_code' => 'nullable|exists:question_categories,code'
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
