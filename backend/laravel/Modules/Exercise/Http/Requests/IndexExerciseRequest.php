<?php

namespace Modules\Exercise\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexExerciseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sport' => 'string|exists:sports,code',
            'name' => 'string',
            'page' => 'integer',
            'per_page' => 'integer'
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
