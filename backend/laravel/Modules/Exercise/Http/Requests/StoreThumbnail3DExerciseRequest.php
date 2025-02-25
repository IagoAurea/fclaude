<?php

namespace Modules\Exercise\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreThumbnail3DExerciseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @OA\Schema(
     *  schema="StoreThumbnail3DExerciseRequest",
     *  @OA\Property(property="thumbnail", type="string" )
     * )
     */
    public function rules()
    {
        return [
            'thumbnail' => 'required|image|mimes:jpeg,png'
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
