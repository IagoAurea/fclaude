<?php

namespace Modules\Activity\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type'  =>  'required',
            'id'    =>  'required',
            'type_profile' => 'string'
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
