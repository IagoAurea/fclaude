<?php

namespace Modules\Fisiotherapy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|required',
            'specialty' => 'string|nullable',
            'anamnesis' => 'string|nullable',
            'observation' => 'string|nullable',
            'has_medication' => 'boolean|nullable',
            'medication' => 'string|nullable',
            'medication_objective' => 'string|nullable',
            'team_staff_id' => 'required|exists:staff_users,id',
            'injury_id' => 'nullable|exists:injuries,id',
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
