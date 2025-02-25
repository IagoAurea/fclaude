<?php

namespace Modules\AlumnControl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyControlAlumnRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="StoreDailyControlAlumnRequest",
     *  type="object",
     *  required={
     *      "alumn_id",
     *      "classroom_academic_year_id",
     *      "control_items"
     *  },
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
     *  @OA\Property(
     *      title="Control Items",
     *      property="control_items",
     *      description="Set of control daily control items to be related with the alumn",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(
     *              property="daily_control_item_id",
     *              format="int64",
     *              example="1",
     *          ),
     *          @OA\Property(
     *              property="count",
     *              format="int64",
     *              example="0",
     *          ),
     *      )
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'alumn_id' => 'required|exists:alumns,id',
            'classroom_academic_year_id' => 'required|exists:classroom_academic_years,id',
            'academic_period_id' => 'nullable|exists:academic_periods,id',
            'control_items' => 'array',
            'control_items.*.daily_control_item_id' => 'exists:daily_control_items,id',
            'control_items.*.count' => 'integer',
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
