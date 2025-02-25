<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="StoreTestTypeRequest",
     *  @OA\Property(
     *      property="name_spanish",
     *      format="string",
     *      example="Especial dos",
     *  ),
     *  @OA\Property(
     *      property="name_english",
     *      format="string",
     *      example="Special two"
     *  ),
     *  @OA\Property(
     *      property="code",
     *      format="string",
     *      example="special_test"
     *  ),
     *  @OA\Property(
     *      property="classification",
     *      description="If is for RFD (1), tests (2) or both (3)",
     *      format="integer",
     *      example="3"
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'name_spanish' => 'required|string',
            'name_english' => 'required|string',
            'code' => 'required',
            'classification' => 'required|integer|min:1|max:3',
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
