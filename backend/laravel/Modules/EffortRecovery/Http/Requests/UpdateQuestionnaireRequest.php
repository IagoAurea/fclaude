<?php

namespace Modules\EffortRecovery\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionnaireRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
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
