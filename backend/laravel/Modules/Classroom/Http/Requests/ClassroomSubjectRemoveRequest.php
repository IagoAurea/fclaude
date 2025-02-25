<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomSubjectRemoveRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *      schema="ClassroomSubjectRemoveRequest",
     *      @OA\Property( title="Teacher ID", property="teacher_id", description="Identifier of the theacher", format="integer", example="1"),
     *      @OA\Property( title="Subject ID", property="subject_id", description="Identifier of the subject", format="integer", example="1"),
     * )
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacher_id' => 'required|integer|exists:classroom_teachers,id',
            'subject_id' => 'required|integer|exists:classroom_subjects,id'
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
