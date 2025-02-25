<?php

namespace Modules\Club\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Custom Validation Rules
use Modules\Generality\Rules\StringArray;

class StoreClubRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     *  @OA\Schema(
     *      schema="StoreClubRequest",
     *      @OA\Property(
     *          title="Club Name",
     *          property="name",
     *          description="Club's full name",
     *          format="string",
     *          example="John Doe"
     *      ),
     *      @OA\Property(
     *          title="Country",
     *          property="country_id",
     *          description="Country",
     *          format="int64", example="1"
     *      ),
     *      @OA\Property(
     *          title="Province",
     *          property="province_id",
     *          description="Province",
     *          format="int64",
     *          example="10"
     *      ),
     *      @OA\Property(
     *          title="Street Address",
     *          property="street",
     *          description="Club's Street Address",
     *          format="string",
     *          example="España Alcoi"
     *      ),
     *      @OA\Property(
     *          title="City",
     *          property="city",
     *          description="City",
     *          format="string", example="Alcoi"
     *      ),
     *      @OA\Property(
     *          title="Postal Code",
     *          property="postal_code",
     *          description="Zip Code",
     *          format="string",
     *          example="33066"
     *      ),
     *      @OA\Property(
     *          title="Phone",
     *          property="phone",
     *          description="Phone",
     *          format="array",
     *          example="['+34424445456']"
     *      ),
     *      @OA\Property(
     *          title="Club Phone",
     *          property="mobile_phone",
     *          description="Club Phone",
     *          format="array", example="[+34424445456]"
     *      ),
     *      @OA\Property(
     *          title="Club's Image",
     *          property="image",
     *          description="Club's photograph or main image",
     *          type="file"
     *      ),
     *  )
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'street' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'city' => 'nullable|string',
            'mobile_phone' => ['nullable', 'string', new StringArray],
            'phone' => ['nullable', 'string', new StringArray],
            'country_id' => 'nullable|integer|exists:countries,id',
            'province_id' => 'nullable|integer|exists:provinces,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048',
        ];
    }

    /**
     * Determine if the user is authorized to make this request
     * depending on the already owned clubs and the maximum club quantity
     * allowed by the subscription.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
