<?php

namespace Modules\Exercise\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddClassroomsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @OA\Schema(
     *  schema="AddClassroomsRequest",
     *  type="object",
     *  required={
     *      "classrooms"
     *  },
     *  @OA\Property(
     *      property="classrooms",
     *      format="array",
     *      example="[1, 2, 3]"
     *  )
     * )
     */
    public function rules()
    {
        return [
            'classrooms' => 'required|array',
            'classrooms.*' => 'required|integer|exists:classrooms,id'
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
