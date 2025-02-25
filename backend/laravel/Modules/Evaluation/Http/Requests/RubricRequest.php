<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="RubricRequest",
 *      @OA\Property(
 *          title="Name",
 *          property="name",
 *          description="String representing the name of the rubric",
 *          format="string",
 *          example="Baloncesto"
 *      ),
 *      @OA\Property(
 *          title="Indicators",
 *          property="indicators",
 *          description="String representing the ids of the associated indicators",
 *          format="string",
 *          example="1,2"
 *      ),
 *      @OA\Property(
 *          title="Academic Year Classrooms",
 *          property="classroom_academic_year_ids",
 *          description="String representing the ids of the associated academic years for that rubric",
 *          format="string",
 *          example="1,2"
 *      ),
 *  )
 */
class RubricRequest extends FormRequest
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
            'indicators' => 'array|required',
            'indicators.*.name' => 'required|max:255',
            'indicators.*.competences' => 'required',
            'indicators.*.percentage' => 'required|numeric|min:1|max:100',
            'indicators.*.evaluation_criteria' => 'max:255',
            'indicators.*.insufficient_caption' => 'max:255',
            'indicators.*.sufficient_caption' => 'max:255',
            'indicators.*.remarkable_caption' => 'max:255',
            'indicators.*.outstanding_caption' => 'max:255'
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
