<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRubricRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|required',
            'classroom_academic_year_ids' => 'integer',
            'indicators' => 'array|required',
            'indicators.*.percentage' => 'required|integer',
            'indicators.*.name' => 'required|string|min:2',
            'indicators.*.competences' => 'array',
            'indicators.*.evaluation_criteria' => 'nullable|string',
            'indicators.*.insufficient_caption' => 'nullable|string',
            'indicators.*.outstanding_caption' => 'nullable|string',
            'indicators.*.outstanding_caption' => 'nullable|string',
            'indicators.*.remarkable_caption' => 'nullable|string',
            'indicators.*.sufficient_caption' => 'nullable|string'
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
