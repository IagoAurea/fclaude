<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="ClassroomStoreRequest",
 *      description="The classroom store request of a school center",
 *      @OA\Xml( name="ClassroomStoreRequest"),
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
 *          title="Age",
 *          property="age_id",
 *          description="Identifier representing the age",
 *          format="string",
 *          example="1"
 *      )
 * )
 */
class ClassroomStoreRequest extends FormRequest
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
            'image' => 'required_without:color|image|mimes:jpeg,png,jpg,svg|min:1|max:2048',
            'color' => 'nullable|max:7',
            'age_id' => 'integer|exists:classroom_ages,id'
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
