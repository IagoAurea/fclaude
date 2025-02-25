<?php

namespace Modules\Generality\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaxRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     * @OA\Schema(
     *  schema="UpdateTaxRequest",
     *  type="object",
     *  required={
     *      "name",
     *      "value",
     *      "type",
     *      "type_user",
     *      "taxable_id"
     *  },
     *  @OA\Property(
     *      property="name",
     *      format="string",
     *      example="Tax name"
     *  ),
     *  @OA\Property(
     *      property="value",
     *      format="decimal",
     *      example="5.22"
     *  ),
     *  @OA\Property(
     *      property="type",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="type_user",
     *      format="boolean",
     *      example="true"
     *  ),
     *  @OA\Property(
     *      property="taxable_id",
     *      format="int64",
     *      example="1"
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'value' => 'required|integer',
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
