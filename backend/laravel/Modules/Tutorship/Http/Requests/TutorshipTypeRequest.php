<?php

namespace Modules\Tutorship\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Get the validation rules that apply to the request.
 * @return array
 * 
 *  @OA\Schema(
 *      schema="TutorshipTypeRequest",
 *      @OA\Property(
 *          title="Name",
 *          property="name",
 *          description="String representing the name of the tutorship type",
 *          format="string",
 *          example="Baloncesto"
 *      )
 *  )
 */
class TutorshipTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|max:255',
            'en' => 'required|array'
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
