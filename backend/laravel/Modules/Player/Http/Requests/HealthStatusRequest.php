<?php

namespace Modules\Player\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HealthStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     *  @OA\Schema(
     *   schema="HealthStatusRequest",
     *   @OA\Property(title="Diseases", property="diseases", format="array", example="[1, 2]"),
     *   @OA\Property(title="Allergies", property="allergies", format="array", example="[1, 2]"),
     *   @OA\Property(title="Body Areas", property="body_areas", format="array", example="[1, 2]"),
     *   @OA\Property(title="Physical problems", property="physical_problems", format="array", example="[1, 2]"),
     *   @OA\Property(title="Medicine types", property="medicine_types", format="array", example="[1, 2]"),
     *   @OA\Property(title="Tobacco consumptions", property="tobacco_consumptions", format="int64", example="1"),
     *   @OA\Property(title="Alcohol consumptions", property="alcohol_consumptions", format="int64", example="1"),
     *   @OA\Property(
     *          property="surgeries",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(title="Diseases ID", property="disease_id", format="int64", example="1"),
     *              @OA\Property(title="Sugery date", property="surgery_date", format="string", example="2000-10-01"),
     *          ),
     *      ),
     *  )
     */
    public function rules()
    {
        return [
            'diseases' => 'sometimes|nullable|array',
            'diseases.*' => 'required|integer',
            'allergies' => 'sometimes|nullable|array',
            'allergies.*' => 'required|integer',
            'body_areas' => 'sometimes|nullable|array',
            'body_areas.*' => 'required|integer',
            'physical_problems' => 'sometimes|nullable|array',
            'physical_problems.*' => 'required|integer',
            'medicine_types' => 'sometimes|nullable|array',
            'medicine_types.*' => 'required|integer',
            'tobacco_consumptions' => 'sometimes|nullable|integer',
            'alcohol_consumptions' => 'sometimes|nullable|integer',
            'surgeries' => 'sometimes|nullable|array',
            'surgeries.*.disease_id' => 'required|integer',
            'surgeries.*.surgery_date' => 'required|date',
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
