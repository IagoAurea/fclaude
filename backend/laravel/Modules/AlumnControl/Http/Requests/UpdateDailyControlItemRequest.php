<?php

namespace Modules\AlumnControl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyControlItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     *
     * @OA\Schema(
     *  schema="UpdateDailyControlItemRequest",
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
     *      example="5.5",
     *  ),
     *  @OA\Property(
     *      title="Image",
     *      property="image_id",
     *      description="related image",
     *      format="file",
     *      example="example_title",
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'en' => 'string|nullable',
            'es' => 'string|nullable',
            'code' => 'string|nullable|min:2',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048'
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
