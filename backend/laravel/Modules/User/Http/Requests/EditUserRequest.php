<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
  /**
 * @OA\Schema(
 *   schema="EditUserRequest",
 *   @OA\Property( title="Email", property="email", description="Email", format="email", example="user@example.com" ),
 *   @OA\Property( title="Full Name", property="full_name", description="Full name user", format="string", example="John Doe" ),
 *   @OA\Property( title="Username", property="username", description="Username user", format="string", example="JohnDoe" ),
 *   @OA\Property( title="Password", property="password", description="password", format="password", example="Anypass12345$" ),
 *   @OA\Property( title="Password Confirmation", property="password_confirmation", description="confirmation password", format="password", example="Anypass12345$" ),
 *   @OA\Property( title="Gender Identification", property="gender_id", description="Identificator of user's gender", format="int64", example="1"),
 *   @OA\Property( title="Gender Identity Identification", property="gender_identity_id", description="Identificator of user's gender identity", format="int64", example="1"),
 *   @OA\Property( title="Country", property="country_id", description="Country", format="int64", example="1" ),
 *   @OA\Property( title="Province", property="province_id", description="Province", format="int64", example="10" ),
 *   @OA\Property( title="City", property="city", description="City", format="string", example="Alcoi" ),
 *   @OA\Property( title="Zipcode", property="zipcode", description="Zip Code", format="string", example="33066" ),
 *   @OA\Property( title="Phone", property="phone", description="Phone", format="array", example="[+34424445456]" ),
 *   @OA\Property( title="Mobile Phone", property="mobile_phone", description="Mobile Phone", format="array", example="[+34424445456]" ),
 *   @OA\Property( title="Is Company", property="is_company", description="Is company", format="boolean", example="true" ),
 *   @OA\Property( title="Company Name", property="company_name", description="Company Name", format="string", example="Comany Test" ),
 *   @OA\Property( title="Company Number", property="company_idnumber", description="Company Number", format="string", example="12345" ),
 *   @OA\Property( title="Company VAT", property="company_vat", description="Company VAT", format="string", example="VAT12345" ),
 *   @OA\Property( title="Company Address", property="company_address", description="Company Address", format="string", example="España Alcoi" ),
 *   @OA\Property( title="Company City", property="company_city", description="Company city", format="string", example="Alcoi" ),
 *   @OA\Property( title="Company Zip Code", property="company_zipcode", description="Company zip code", format="string", example="33068" ),
 *   @OA\Property( title="Company Phone", property="company_phone", description="Company phone", format="string", example="+34ssd33068" ),
 *   @OA\Property( title="Provider Google", property="provider_google_id", description="Provider Google Id", format="string", example="Adsds343fd64f" ),
 *   @OA\Property( title="Provider User logo", property="image", description="User logo", type="file"),
 *   @OA\Property( title="Provider User cover", property="cover", description="User cover", type="file"),
 * )
 */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'email' => 'nullable|email|unique:users,email,'.$this->id,
            'full_name' => 'nullable|string|min:3|max:255',
            'username' => 'nullable|string|unique:users,username,'.$this->id,
            'password' => 'nullable|min:8|confirmed|string|regex:/^(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*\d)(?=.*([-+_!@#$%^&*.,;?])).+$/',
            'gender_id' => 'nullable|integer',
            'gender_identity_id' => 'nullable|integer',
            'address' => 'nullable|min:3',
            'country_id' => 'nullable|integer|exists:countries,id',
            'province_id' => 'nullable|integer|exists:provinces,id',
            'city' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'phone' => 'nullable|array',
            'mobile_phone' => 'nullable|array',
            'is_company' => 'string|in:true,false',
            'company_name' => 'nullable|string',
            'company_idnumber' => 'nullable|string',
            'company_vat' => 'nullable|string',
            'company_address' => 'nullable|string',
            'company_city' => 'nullable|string',
            'company_zipcode' => 'nullable|string',
            'company_phone' => 'nullable|string',
            'provider_google_id' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048',
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
