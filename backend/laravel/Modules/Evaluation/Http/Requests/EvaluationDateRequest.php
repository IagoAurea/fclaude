<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="EvaluationDateRequest",
 *      @OA\Property(
 *          title="Evaluation Date",
 *          property="evaluation_date",
 *          description="Date of the evaluation to be applied",
 *          format="date",
 *          example="2022-03-20"
 *      )
 *  )
 */
class EvaluationDateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'evaluation_date' => 'required|date_format:Y-m-d'
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
