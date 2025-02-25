<?php

namespace Modules\AlumnControl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetDailyControlAlumnRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="ResetDailyControlAlumnRequest",
     *  type="object",
     *  @OA\Property(
     *      title="Alumn ID",
     *      property="alumn_id",
     *      description="Alumn identificator",
     *      format="int64",
     *      example="1",
     *  ),
     *  @OA\Property(
     *      title="Classroom Academic Year ID",
     *      property="classroom_academic_year_id",
     *      description="Academic year identificator",
     *      format="int64",
     *      example="1",
     *  ),
     *  @OA\Property(
     *      title="Academic Period ID",
     *      property="academic_period_id",
     *      description="Academic period identificator",
     *      format="string",
     *      example="1",
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'alumn_id' => 'nullable|exists:alumns,id',
            'classroom_academic_year_id' => 'nullable|exists:classroom_academic_years,id',
            'academic_period_id' => 'nullable|exists:academic_periods,id',
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
