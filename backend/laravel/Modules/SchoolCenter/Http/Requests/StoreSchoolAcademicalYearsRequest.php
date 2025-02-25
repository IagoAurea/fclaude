<?php

namespace Modules\SchoolCenter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolAcademicalYearsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="StoreSchoolAcademicalYearsRequest",
     *  type="object",
     *  @OA\Property(
     *      property="academic_years",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="title", format="string", example="string"),
     *          @OA\Property(property="start_date", format="date", example="2020-01-01"),
     *          @OA\Property(property="end_date", format="date", example="2020-01-01"),
     *          @OA\Property(property="is_active", format="boolean", example="1"),
     *          @OA\Property(
     *              property="periods",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="title", format="string", example="string"),
     *                  @OA\Property(property="start_date", format="date", example="2020-01-01"),
     *                  @OA\Property(property="end_date", format="date", example="2020-01-01"),
     *                  @OA\Property(property="is_active", format="boolean", example="1"),
     *              )
     *          )
     *      )
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'academic_years' => 'array|required',
            'academic_years.*.title' => 'string|nullable',
            'academic_years.*.start_date' => 'date|required',
            'academic_years.*.end_date' => 'date|required',
            'academic_years.*.is_active' => 'boolean',
            'academic_years.*.periods' => 'array|required',
            'academic_years.*.periods.*.title' => 'string|nullable',
            'academic_years.*.periods.*.start_date' => 'date|required',
            'academic_years.*.periods.*.end_date' => 'date|required',
            'academic_years.*.periods.*.is_active' => 'boolean',
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
