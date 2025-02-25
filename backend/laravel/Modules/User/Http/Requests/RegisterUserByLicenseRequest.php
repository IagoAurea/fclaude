<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserByLicenseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="RegisterUserByLicenseRequest",
     *  type="object",
     *  required={
     *      "email",
     *      "full_name",
     *  },
     *  @OA\Property(
     *      property="email", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="username", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="full_name", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="address", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="dni", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="zipcode", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="phone", format="array", example="['+34-658454874']",
     *  ),
     *  @OA\Property(
     *      property="mobile_phone", format="array", example="['+34424445456']"
     *  ),
     *  @OA\Property(
     *      property="is_company", format="boolean", example="true",
     *  ),
     *  @OA\Property(
     *      property="company_name", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="company_idnumber", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="company_vat", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="company_address", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="company_city", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="company_zipcode", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="company_phone", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="password", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="password_confirmation", format="string", example="string",
     *  ),
     *  @OA\Property(
     *      property="country_id", format="int64", example="1",
     *  ),
     *  @OA\Property(
     *      property="province_id", format="int64", example="1",
     *  ),
     *  @OA\Property(
     *      property="license_invite_token", format="string", example="string",
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string|min:3',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed|string|regex:/^(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*\d)(?=.*([-+_!@#$%^&*.,;?])).+$/',
            'address' => 'required|min:3',
            'country_id' => 'required|integer|exists:countries,id',
            'username' => 'nullable|string|unique:users,username',
            'province_id' => 'nullable|integer|exists:provinces,id',
            'city' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'phone' => 'nullable|array',
            'mobile_phone' => 'nullable|array',
            'is_company' => 'nullable|boolean',
            'company_name' => 'nullable|string',
            'company_idnumber' => 'nullable|string',
            'company_vat' => 'nullable|string',
            'company_address' => 'nullable|string',
            'company_city' => 'nullable|string',
            'company_zipcode' => 'nullable|string',
            'company_phone' => 'nullable|string',
            'provider_google_id' => 'nullable|string',
            'club_invite_token' => 'nullable|string|exists:club_invitations,code',
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
