<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignYearsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     *
     * @OA\Schema(
     *  schema="AssignClassroomYearsRequest",
     *  type="object",
     *  required={
     *      "academic_year_ids",
     *  },
     *  @OA\Property(
     *      property="academic_year_ids",
     *      format="array",
     *      example="[1, 2, 3]"
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'academic_year_ids' => 'required|array',
            'academic_year_ids.*' => 'integer|exists:academic_years,id',
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
