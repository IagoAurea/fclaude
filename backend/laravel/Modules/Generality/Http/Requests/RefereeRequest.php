<?php


namespace Modules\Generality\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class RefereeRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 
     * @OA\Schema(
     *  schema="StoreRefereeRequest",
     *  type="object",
     *  required={
     *      "name",
     *      "team_id"
     *  },
     *  @OA\Property(property="name", format="string", example="Jose Claric"),
     *  @OA\Property(property="team_id", format="int64", example="1"),
     * )
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'team_id' => 'nullable|exists:teams,id',
            'country_id' => 'nullable|exists:countries,id',
            'province_id' => 'nullable|exists:provinces,id'
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
