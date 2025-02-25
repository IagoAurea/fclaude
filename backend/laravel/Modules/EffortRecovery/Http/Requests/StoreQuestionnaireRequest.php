<?php

namespace Modules\EffortRecovery\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionnaireRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     * @OA\Schema(
     *  schema="StoreQuestionnaireRequest",
     *  type="object",
     *  @OA\Property(
     *      property="answer_items",
     *      format="array",
     *      example="[1, 6, 11, 16, 21]"
     *  )
     * )
     */
    public function rules()
    {
        return [
            'answer_items'         =>  'array|required',
            'answer_items.*'       =>  'integer|exists:wellness_questionnaire_answer_items,id',
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
