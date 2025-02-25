<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="TeacherStoreRequest",
 *      description="The teacher store request of a school center",
 *      @OA\Xml( name="Teacher"),
 *      @OA\Property(
 *          title="Name",
 *          property="name",
 *          description="String representing the name",
 *          format="string",
 *          example="Math"
 *      ),
 *      @OA\Property(
 *          title="Email",
 *          property="email",
 *          description="String representing the email",
 *          format="string",
 *          example="teacher@example.com"
 *      ),
 *      @OA\Property(
 *          title="School Center",
 *          property="club_id",
 *          description="Identifier of the school center it belongs to",
 *          format="string",
 *          example="11"
 *      ),
 *      @OA\Property(
 *          title="Teacher Area",
 *          property="teacher_area_id",
 *          description="Identifier of the area",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Gender Identification",
 *          property="gender_id",
 *          description="Identificator of alumn's gender",
 *          format="int64",
 *          example="1"
 *      ),
 *       @OA\Property(
 *          title="Alias",
 *          property="alias",
 *          description="String representing the alias",
 *          format="string",
 *          example="Jhon"
 *       ),
 *       @OA\Property(
 *          title="Date of Birth",
 *          property="date_of_birth",
 *          description="String representing the date of birth",
 *          format="string",
 *          example="M"
 *       ),
 *       @OA\Property(
 *          title="Citizenship",
 *          property="citizenship",
 *          description="String representing the citizenship",
 *          format="string",
 *          example="Spain"
 *       ),
 *       @OA\Property(
 *          title="Position",
 *          property="position",
 *          description="String representing the position",
 *          format="string",
 *          example="CEO"
 *       ),
 *       @OA\Property(
 *          title="Study Level",
 *          property="study_level_id",
 *          description="Identifier of the study level",
 *          format="string",
 *          example="1"
 *       ),
 *       @OA\Property(
 *          title="Department chief",
 *          property="department_chief",
 *          description="Is the chief of the department?",
 *          format="boolean",
 *          example="false"
 *       ),
 *       @OA\Property(
 *          title="Class tutor",
 *          property="class_tutor",
 *          description="Is the tutor of a class?",
 *          format="boolean",
 *          example="false"
 *       ),
 *       @OA\Property(
 *          title="Total courses",
 *          property="total_courses",
 *          description="Number of courses on the current club",
 *          format="integer",
 *          example="1"
 *       ),
 *       @OA\Property(
 *          title="Working experiences",
 *          property="work_experiences",
 *          description="Working experiences",
 *          format="array",
 *          example="[{'club':'club test','occupation':'teacher','start_date':'2022-12-01','finish_date':'2022-12-15'}]"
 *      )
 * )
 */
class TeacherStoreRequest extends FormRequest
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
            'email' => 'required|max:255|email',
            'teacher_area_id' => 'required|max:255',
            'gender_id' => 'max:255',
            'alias' => 'max:255',
            'date_of_birth' => 'max:255',
            'citizenship' => 'max:255',
            'position_staff_id' => 'integer|max:255',
            'responsibility' => 'max:255',
            'study_level_id' => 'integer|exists:study_levels,id',
            'department_chief' => 'boolean',
            'class_tutor' => 'boolean',
            'total_courses' => 'integer|min:0',
            'additional_information' => 'max:255',
            'work_experiences' => 'string'
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
