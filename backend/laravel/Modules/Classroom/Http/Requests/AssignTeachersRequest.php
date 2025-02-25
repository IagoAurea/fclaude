<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTeachersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="AssignTeachersRequest",
     *  type="object",
     *  @OA\Property(
     *      property="classroom_academic_year_id",
     *      format="string",
     *      example="1"
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'physical_teacher_id' => 'required|max:255',
            'tutor_id' => 'required|max:255',
            'subject_id' => 'required_without:subject_text|integer|exists:classroom_subjects,id',
            'subject_text' => 'nullable|string',
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
