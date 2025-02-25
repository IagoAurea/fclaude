<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="IndicatorRequest",
 *      @OA\Property(
 *          title="Name",
 *          property="name",
 *          description="String representing the name of the indicator",
 *          format="string",
 *          example="Rendimiento del jugador respecto al cuerpo"
 *      ),
 *      @OA\Property(
 *          title="Percentage",
 *          property="percentage",
 *          description="The percentage of the current indicator on a rubric",
 *          format="string",
 *          example="10"
 *      ),
 *      @OA\Property(
 *          title="Evaluation Criteria",
 *          property="evaluation_criteria",
 *          description="A string representing the evaluation criteria",
 *          format="string",
 *          example="CE21"
 *      ),
 *      @OA\Property(
 *          title="Insufficient Caption",
 *          property="insufficient_caption",
 *          description="A string representing the caption for insufficient results",
 *          format="string",
 *          example=""
 *      ),
 *      @OA\Property(
 *          title="Sufficient Caption",
 *          property="sufficient_caption",
 *          description="A string representing the caption for sufficient results",
 *          format="string",
 *          example=""
 *      ),
 *      @OA\Property(
 *          title="Remarkable Caption",
 *          property="remarkable_caption",
 *          description="A string representing the caption for remarkable results",
 *          format="string",
 *          example=""
 *      ),
 *      @OA\Property(
 *          title="Outstanding Caption",
 *          property="outstanding_caption",
 *          description="A string representing the caption for outstanding results",
 *          format="string",
 *          example=""
 *      ),
 *  )
 */
class IndicatorRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'percentage' => 'required|numeric|min:1|max:100',
            'evaluation_criteria' => 'max:255',
            'insufficient_caption' => 'max:255',
            'sufficient_caption' => 'max:255',
            'remarkable_caption' => 'max:255',
            'outstanding_caption' => 'max:255'
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
