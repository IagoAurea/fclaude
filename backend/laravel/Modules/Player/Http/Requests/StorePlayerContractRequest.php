<?php

namespace Modules\Player\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerContractRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 
     *  @OA\Schema(
     *   schema="StorePlayerContractRequest",
     *   required={
     *     "duration",
     *     "contract_creation"
     *   },
     *   @OA\Property(title="Title", property="title", description="title", format="string", example="Contract" ),
     *   @OA\Property(title="Duration", property="year_duration", description="duration", format="integer", example="2" ),
     *   @OA\Property(title="Contract creation", property="contract_creation", description="contract creation", format="date", example="2023-01-15" ),
     *   @OA\Property(title="Image", property="image", description="image", type="file" ),
     *  )
     */
    public function rules()
    {
        return [
            'title' => 'string',
            'year_duration' => 'integer|required',
            'contract_creation' => 'date|required',
            'image' => 'image|mimes:jpeg,png,jpg,svg|min:1|max:2048'
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
