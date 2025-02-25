<?php

namespace Modules\Scouting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoutingFinishRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'in_game_time' => 'required',
            'in_real_time' => 'nullable'
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
