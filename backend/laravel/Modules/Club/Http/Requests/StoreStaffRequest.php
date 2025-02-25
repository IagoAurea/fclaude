<?php

namespace Modules\Club\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="StoreStaffUserRequest",
     *  required={
     *      "full_name",
     *      "jobs_area_id",
     *      "position_staff_id",
     *      "gender_id",
     *  },
     *  @OA\Property(
     *      title="Staff Name",
     *      property="full_name",
     *      format="string",
     *      example="string"
     *  ),
     *  @OA\Property(
     *      title="Username",
     *      property="username",
     *      format="string", 
     *      example="string",
     *  ),
     *  @OA\Property(
     *      title="Date of birth",
     *      property="birth_date",
     *      type="string",
     *      format="date", 
     *      example="2020-01-01",
     *  ),
     *  @OA\Property(
     *      title="Email",
     *      property="email",
     *      format="string", 
     *      example="string"
     *  ),
     *  @OA\Property(
     *      title="Gender Identification",
     *      property="gender_id",
     *      format="int64", 
     *      example="1"
     *  ),
     *  @OA\Property(
     *      title="Staff Image",
     *      property="image",
     *      type="file"
     *  ),
     *  @OA\Property(
     *      title="Country",
     *      property="country_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      title="Province",
     *      property="province_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      title="Street Address",
     *      property="street",
     *      format="string",
     *      example="string"
     *  ),
     *  @OA\Property(
     *      title="City",
     *      property="city",
     *      format="string",
     *      example="string"
     *  ),
     *  @OA\Property(
     *      title="Postal Code",
     *      property="postal_code",
     *      format="string",
     *      example="33066"
     *  ),
     *  @OA\Property(
     *      title="Mobile Phone",
     *      property="mobile_phone",
     *      format="array",
     *      example="[+34424445456]"
     *  ),
     *  @OA\Property(
     *      title="Responsibity",
     *      property="responsibility",
     *      format="string",
     *      example="string"
     *  ),
     *  @OA\Property(
     *      title="Additional Information",
     *      property="additional_information",
     *      format="string",
     *      example="string"
     *  ),
     *  @OA\Property(
     *      title="Job Area",
     *      property="jobs_area_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      title="Job Area",
     *      property="position_staff_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      title="Study Level",
     *      property="study_level_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      title="Work Experience",
     *      property="work_experience",
     *      format="string",
     *      example="[{ 'name': 'Example name1', 'occupation': 'Testing ocupattion', 'start_date': '2022-01-01', 'finish_date': '2022-02-01' }]"
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string',
            'jobs_area_id' => 'required|integer|exists:jobs_area,id',
            'position_staff_id' => 'required|integer|exists:position_staff,id',
            'gender_id' => 'integer',
            'email' => 'email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048',
            'city' => 'nullable|string',
            'street' => 'nullable|string',
            'postal_code' => 'nullable|string',
            'country_id' => 'integer|exists:countries,id',
            'province_id' => 'integer|exists:provinces,id',
            'mobile_phone' => 'nullable|json',
            'responsibility' => 'string',
            'study_level_id' => 'string|exists:study_levels,id',
            'work_experience' => 'nullable|json',
            'additional_information' => 'nullable|string',
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
