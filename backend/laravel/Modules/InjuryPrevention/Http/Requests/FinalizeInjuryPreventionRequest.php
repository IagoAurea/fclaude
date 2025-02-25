<?php

namespace Modules\InjuryPrevention\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinalizeInjuryPreventionRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     * @OA\Schema(
     *  schema="FinalizeInjuryPreventionRequest",
     *  type="object",
     *  @OA\Property(
     *      property="answers",
     *      type="array",
     *      example={{
     *          "evaluation_question_id": 2,
     *          "value": true
     *      }, {
     *          "evaluation_question_id": 4,
     *          "value": true
     *      }},
     *      @OA\Items(
     *          @OA\Property(
     *              property="evaluation_question_id",
     *              type="int64",
     *              example=""
     *          ),
     *          @OA\Property(
     *              property="value",
     *              type="boolean",
     *              example=""
     *          ),
     *      )
     *  )
     * )
     */
    public function rules()
    {
        return [
            'answers' => 'array|required'
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
