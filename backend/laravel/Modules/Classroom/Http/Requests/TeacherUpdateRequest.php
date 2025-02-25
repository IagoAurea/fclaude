<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="TeacherUpdateRequest",
 *      description="The teacher update request of a school center",
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
 *          title="Gender",
 *          property="gender",
 *          description="String representing the gender",
 *          format="string",
 *          example="M"
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
 *      @OA\Property(
 *          title="Working experiences",
 *          property="work_experiences",
 *          description="Working experiences",
 *          format="array",
 *          example="[{'club':'club test','occupation':'teacher','start_date':'2022-12-01','finish_date':'2022-12-15'}]"
 *      )
 * )
 */
class TeacherUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'max:255',
            'email' => 'max:255|email',
            'teacher_area_id' => 'max:255',
            'club_id' => 'max:255',
            'gender' => 'max:255',
            'alias' => 'max:255',
            'date_of_birth' => 'max:255',
            'citizenship' => 'max:255',
            'position_staff_id' => 'max:255',
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
