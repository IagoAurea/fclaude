<?php

namespace Modules\Exercise\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddTeamsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @OA\Schema(
     *  schema="AddTeamsRequest",
     *  type="object",
     *  required={
     *      "teams"
     *  },
     *  @OA\Property(
     *      property="teams",
     *      format="array",
     *      example="[1, 2, 3]"
     *  )
     * )
     */
    public function rules()
    {
        return [
            'teams' => 'required|array',
            'teams.*' => 'required|integer|exists:teams,id'
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
