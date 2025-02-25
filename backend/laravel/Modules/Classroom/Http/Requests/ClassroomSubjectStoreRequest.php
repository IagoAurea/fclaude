<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassroomSubjectStoreRequest extends FormRequest
{
    /**
     *  @OA\Schema(
     *      schema="ClassroomSubjectStoreRequest",
     *      @OA\Property(
     *          title="Teacher ID", property="teacher_id",
     *          description="Identifier of the theacher", format="integer", example="1"),
     *      @OA\Property(
     *          title="Subject ID", property="subject_id",
     *          description="Identifier of the subject", format="integer", example="1"),
     *      @OA\Property(
     *          title="Tutor class", property="is_class_tutor",
     *          description="Is class tutor", format="boolean", example="false" )
     * )
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacher_id' => 'required|integer|exists:classroom_teachers,id',
            'subject_id' => 'required|integer|exists:classroom_subjects,id',
            'is_class_tutor' => 'boolean'
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
