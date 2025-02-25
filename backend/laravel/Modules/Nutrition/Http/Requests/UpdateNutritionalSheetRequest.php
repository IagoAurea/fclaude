<?php

namespace Modules\Nutrition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNutritionalSheetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'take_supplements' => 'required|bool',
            'take_diets' => 'required|bool',
            'activity_factor' => 'required|numeric',
            'total_energy_expenditure' => 'required|numeric',
            'player_id' => 'required|integer'

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
