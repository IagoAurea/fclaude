<?php

namespace Modules\Classroom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="AgeRequest",
 *      @OA\Property(
 *          title="Range",
 *          property="range",
 *          description="String representing the range of ages",
 *          format="string",
 *          example="8-9 years"
 *      )
 *  )
 */
class AgeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'range' => 'required|max:255',
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
