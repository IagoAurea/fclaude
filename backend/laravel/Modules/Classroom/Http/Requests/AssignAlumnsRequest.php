<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignAlumnsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="AssignClassroomAlumnsRequest",
     *  type="object",
     *  required={
     *      "alumn_ids",
     *  },
     *  @OA\Property(
     *      property="alumn_ids",
     *      format="array",
     *      example="[1, 2, 3]"
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'alumn_ids' => 'required|array',
            'alumn_ids.*' => 'integer|exists:alumns,id'
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
