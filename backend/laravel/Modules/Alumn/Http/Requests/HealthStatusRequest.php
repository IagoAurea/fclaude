<?php

namespace Modules\Alumn\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HealthStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'diseases' => 'sometimes|nullable|array',
            'allergies' => 'sometimes|nullable|array',
            'body_areas' => 'sometimes|nullable|array',
            'physical_problems' => 'sometimes|nullable|array',
            'medicine_types' => 'sometimes|nullable|array',
            'tobacco_consumptions' => 'sometimes|nullable|integer',
            'alcohol_consumptions' => 'sometimes|nullable|integer',
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
