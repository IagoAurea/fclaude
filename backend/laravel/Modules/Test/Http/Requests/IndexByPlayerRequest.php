<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexByPlayerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'entity_name' => 'required|string|in:test,rfd,fisiotherapy',
            'team_id' => 'required|integer|exists:teams,id',
            'test_type' => 'string|exists:test_types,code',
            'test_sub_type' => 'string|exists:test_sub_types,code'
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
