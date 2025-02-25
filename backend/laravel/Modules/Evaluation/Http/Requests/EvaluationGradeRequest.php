<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="EvaluationGradeRequest",
 *      @OA\Property(
 *          title="Player Id",
 *          property="alumn_id",
 *          description="Id of the alumn to be register the rubric evaluation in a given classroom",
 *          format="integer",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Classroom Academic Year Id",
 *          property="classroom_academic_year_id",
 *          description="Id of the classroom associated to the rubric evaluation of a alumn",
 *          format="integer",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Evaluation Rubric Id",
 *          property="indicator_rubric_id",
 *          description="Id of the indicator associated to a specific rubric",
 *          format="integer",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Grade",
 *          property="grade",
 *          description="The grade that the alumn obtained for that indicator",
 *          format="integer",
 *          example="5"
 *      )
 *  )
 */
class EvaluationGradeRequest extends FormRequest
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
            'indicator_rubric_id' => 'required|numeric',
            'grade' => 'required|numeric|min:0|max:10'
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
