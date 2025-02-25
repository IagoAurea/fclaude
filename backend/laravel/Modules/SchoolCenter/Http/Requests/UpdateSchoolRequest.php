<?php

namespace Modules\SchoolCenter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Custom Validation Rules
use Modules\Generality\Rules\StringArray;

class UpdateSchoolRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     *  @OA\Schema(
     *      schema="UpdateSchoolRequest",
     *      @OA\Property(
     *          title="School Name",
     *          property="name",
     *          description="School's full name",
     *          format="string",
     *          example="John Doe"
     *      ),
     *      @OA\Property(
     *          title="School Center Type Identificator",
     *          property="school_center_type_id",
     *          description="Identificates the type of school centre to be created",
     *          format="int64", example="1"
     *      ),
     *      @OA\Property(
     *          title="Email",
     *          property="email",
     *          description="Email",
     *          format="email",
     *          example="school@example.com"
     *      ),
     *      @OA\Property(
     *          title="Webpage",
     *          property="webpage",
     *          description="School's webpage",
     *          format="string",
     *          example="www.google.co.ve"
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
     *          description="School's Street Address",
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
     *          title="School Phone",
     *          property="mobile_phone",
     *          description="School Phone",
     *          format="array", example="[+34424445456]"
     *      ),
     *      @OA\Property(
     *          title="School's Image",
     *          property="image",
     *          description="School's photograph or main image",
     *          type="file"
     *      ),
     *  )
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string|min:3',
            'email' => 'sometimes|email',
            'webpage' => 'sometimes|string',
            'street' => 'sometimes|string',
            'postal_code' => 'sometimes|string',
            'city' => 'sometimes|string',
            'mobile_phone' => ['sometimes', 'string', new StringArray],
            'phone' => ['sometimes', 'string', new StringArray],
            'country_id' => 'sometimes|integer|exists:countries,id',
            'province_id' => 'sometimes|integer|exists:provinces,id',
            'school_center_type_id' => 'sometimes|integer|exists:school_center_types,id',
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
