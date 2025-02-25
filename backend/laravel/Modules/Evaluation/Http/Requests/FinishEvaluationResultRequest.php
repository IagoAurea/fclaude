<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="FinishEvaluationResultRequest",
 *      @OA\Property(
 *          title="Alumn Id",
 *          property="alumn_id",
 *          description="Id of the alumn to be register the rubric evaluation in a given classroom",
 *          format="integer",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Classroom Academic Yaer Id",
 *          property="classroom_academic_year_id",
 *          description="Id of the classroom of a specific academic year associated to the rubric evaluation of a alumn",
 *          format="integer",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Rubric Id",
 *          property="rubric_id",
 *          description="Id of the rubric evaluation",
 *          format="integer",
 *          example="1"
 *      )
 *  )
 */
class FinishEvaluationResultRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alumn_id' => 'required|numeric',
            'classroom_academic_year_id' => 'required|numeric',
            'rubric_id' => 'required|numeric'
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
