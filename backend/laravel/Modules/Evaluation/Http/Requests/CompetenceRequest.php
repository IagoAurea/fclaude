<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="CompetenceRequest",
 *      @OA\Property(
 *          title="Name",
 *          property="name",
 *          description="String representing the name of the competence",
 *          format="string",
 *          example="Competencia Digital"
 *      ),
 *      @OA\Property(
 *          title="Acronym",
 *          property="acronym",
 *          description="String representing the acronym of the competence",
 *          format="string",
 *          example="CD"
 *      ),
 *  )
 */
class CompetenceRequest extends FormRequest
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
            'acronym' => 'required|max:255',
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
