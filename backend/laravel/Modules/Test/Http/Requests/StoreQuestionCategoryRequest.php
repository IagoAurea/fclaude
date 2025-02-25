<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionCategoryRequest extends FormRequest
{

    /**
     * @OA\Schema(
     *   schema="StoreQuestionCategoryRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="category name in spanish ", format="string", example="Habilidades Fisicas" ),
     *   @OA\Property( title="Name in English", property="name_english", description="category name in English", format="string", example="Physical Abilities" ),
     *   @OA\Property( title="Code", property="code", description="code to identify", format="string", example="physical_abilities" ),
     *   @OA\Property( title="Question Category Code", property="question_category_code", description="Parent Category", format="string", example="physical_abilities" ),     * )
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
            'question_category_code' => 'nullable|exists:question_categories,code',
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
