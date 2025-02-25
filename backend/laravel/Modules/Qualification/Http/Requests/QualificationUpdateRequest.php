<?php

namespace Modules\Qualification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QualificationUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @OA\Schema(
     *  schema="QualificationUpdateRequest",
     *  type="object",
     *  required={
     *      "classroom_academic_period_id",
     *      "classroom_academic_year_id",
     *      "items",
     *  },
     * @OA\Property(property="classroom_academic_period_id", format="int64", example="1"),
     * @OA\Property(property="classroom_academic_year_id", format="int64", example="1"),
     * @OA\Property(property="title", format="string", example="Qualification"),
     * @OA\Property(property="description", format="string", example="Qualification"),
     * @OA\Property(
     *   property="items",
     *   type="array",
     *   @OA\Items(
     *      @OA\Property(property="classroom_rubric_id", format="int64", example="1"),
     *      @OA\Property(property="name", format="string", example="Rubric 1"),
     *      @OA\Property(property="percentage", format="int64", example="100")
     *    ),
     *   ),
     * )
     */
    public function rules()
    {
        return [
            'classroom_academic_period_id' => 'required|integer|exists:academic_periods,id',
            'classroom_academic_year_id' => 'required|integer|exists:classroom_academic_years,id',
            'description' => 'string|min:3',
            'title' => 'string|min:3',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.percentage' => 'required|integer',
            'items.*.classroom_rubric_id' => 'required|integer'
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
