<?php

namespace Modules\Scouting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoutingActivityUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'player_id' => 'numeric',
            'action_id' => 'numeric',
            'status' => 'boolean',
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
