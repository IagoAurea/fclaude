<?php

namespace Modules\Team\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamStaffRequest extends FormRequest
{
     /**
     * @OA\Schema(
     *   schema="UpdateTeamStaffRequest",
     *   @OA\Property( title="Date Birth", property="date_birth", description="", format="date", example="2021-11-20"),
     *   @OA\Property( title="Full Name", property="full_name", description="", format="string", example="name" ),
     *   @OA\Property( title="Alias", property="alias", description="", format="string", example="alias" ),
     *   @OA\Property( title="Position Staff", property="position_staff_id", description="", format="integer", example="1" ),
     *   @OA\Property( title="Modality", property="gender_id", description="", format="integer", example="1" ),
     *   @OA\Property( title="Nationality", property="nationality_id", description="", format="integer", example="1" ),
     *   @OA\Property( title="Country", property="country_id", description="", format="integer", example="1" ),
     *   @OA\Property( title="Province", property="province_id", description="", format="integer", example="1" ),
     *   @OA\Property( title="City", property="city", description="", format="integer", example="1" ),
     *   @OA\Property( title="Mobile", property="mobile_phone", description="", format="string", example="985645231" ),
     *   @OA\Property( title="Phone", property="phone", description="", format="string", example="985645231" ),
     *   @OA\Property( title="Seasons", property="seasons", description="", format="string", example="season" ),
     *   @OA\Property( title="Zipcode", property="zipcode", description="", format="string", example="12365" ),
     *   @OA\Property( title="Adress", property="address", description="", format="string", example="adress" ),
     *   @OA\Property( title="Study Level", property="study_level_id", description="", format="integer", example="1" ),
     *   @OA\Property( title="Jobs Area", property="jobs_area_id", description="", format="integer", example="1" ),
     *   @OA\Property( title="Adicional Information", property="additional_information", description="", format="string", example="information" ),
     *   @OA\Property( title="Email", property="email", description="", format="email", example="email@email.com" ),
     *   @OA\Property( title="Image", property="image", description= "", format="file", example="" )
     * * )
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date_birth' => 'nullable|date',
            'full_name' => 'required|string|min:3',
            'alias' => 'required|string|min:3',
            'position_staff_id'  => 'required|integer|exists:position_staff,id',
            'gender_id' => 'nullable|integer',
            'nationality_id' => 'nullable|integer|exists:countries,id',
            'country_id' => 'nullable|integer|exists:countries,id',
            'province_id'  => 'nullable|integer|exists:provinces,id',
            'city' => 'nullable|string|max:255',
            'mobile_phone'  => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'seasons' => 'nullable|string|max:255',
            'zipcode'    => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'study_level_id' => 'nullable|integer|exists:study_levels,id',
            'jobs_area_id'  => 'nullable|integer|exists:jobs_area,id',
            'additional_information' => 'nullable',
            'email' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|dimensions:min_width=512,min_height=512|min:1|max:2048'
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
