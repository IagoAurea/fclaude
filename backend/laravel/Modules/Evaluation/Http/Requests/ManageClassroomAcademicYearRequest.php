<?php

namespace Modules\Evaluation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="ManageClassroomAcademicYearRequest",
 *      @OA\Property(
 *          title="Manage Academic Year Classrooms",
 *          property="classroom_academic_year_ids",
 *          description="String representing the ids of the associated academic years for that rubric",
 *          format="string",
 *          example="1,2"
 *      )
 *  )
 */
class ManageClassroomAcademicYearRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'classroom_academic_year_ids' => 'required'
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
