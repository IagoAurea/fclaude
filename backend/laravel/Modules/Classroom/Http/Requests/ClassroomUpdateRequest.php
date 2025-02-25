<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="ClassroomUpdateRequest",
 *      description="The classroom update request of a school center",
 *      @OA\Xml( name="ClassroomUpdateRequest"),
 *      @OA\Property(
 *          title="Name",
 *          property="name",
 *          description="String representing the name",
 *          format="string",
 *          example="Math"
 *      ),
 *      @OA\Property(
 *          title="School Center",
 *          property="club_id",
 *          description="Identifier of the school center it belongs to",
 *          format="string",
 *          example="11"
 *      ),
 *      @OA\Property(
 *          title="Scholar Year",
 *          property="scholar_year",
 *          description="String representing the scholar year",
 *          format="string",
 *          example="2020/2021"
 *      ),
 *      @OA\Property(
 *          title="Age",
 *          property="age_id",
 *          description="Identifier representing the age",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Physical Teacher",
 *          property="physical_teacher_id",
 *          description="Identifier representing the physical teacher",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Tutor",
 *          property="tutor_id",
 *          description="Identifier representing the tutor",
 *          format="string",
 *          example="1"
 *      ),
 *      @OA\Property(
 *          title="Subject",
 *          property="subject_id",
 *          description="Identifier representing the subject",
 *          format="string",
 *          example="1"
 *      )
 * )
 */
class ClassroomUpdateRequest extends FormRequest
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
            'observations' => 'max:255',
            'age_id' => 'max:255'
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
