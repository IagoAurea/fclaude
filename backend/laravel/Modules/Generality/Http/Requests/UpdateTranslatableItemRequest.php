<?php

namespace Modules\Generality\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslatableItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="UpdateTranslatableItemRequest",
     *  @OA\Property(
     *      title="Name in Spanish",
     *      property="es",
     *      description="Spanish typed name",
     *      format="string",
     *      example="Titulo de ejemplo",
     *  ),
     *  @OA\Property(
     *      title="Name in English",
     *      property="en",
     *      description="English typed name",
     *      format="string",
     *      example="Example title",
     *  ),
     *  @OA\Property(
     *      title="Code",
     *      property="code",
     *      description="code",
     *      format="string",
     *      example="example_code",
     *  ),
     * )
     */
    public function rules()
    {
        return [
            //
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
