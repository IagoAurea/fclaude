<?php

namespace Modules\Alumn\Http\Requests;

use Modules\Generality\Rules\StringArray;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Alumn\Rules\AlumnRelationEmail;

class StoreAlumnRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     *
     *  @OA\Schema(
     *      schema="StoreAlumnRequest",
     *      @OA\Property(
     *          title="Alumn Full Name",
     *          property="full_name",
     *          description="Alumn's full name",
     *          format="string",
     *          example="John Doe"
     *      ),
     *      @OA\Property(
     *          title="Email",
     *          property="email",
     *          description="Email",
     *          format="email",
     *          example="user@example.com"
     *      ),
     *      @OA\Property(
     *          title="Laterality Identification",
     *          property="laterality_id",
     *          description="Identificator of alumn's laterality",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Gender Identification",
     *          property="gender_id",
     *          description="Identificator of alumn's gender",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Gender Identity Identification",
     *          property="gender_identity_id",
     *          description="Identificator of alumn's gender identity",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Date Birth",
     *          property="birthdate",
     *          description="Birthdate of the alumn",
     *          format="string",
     *          example="2000-10-01"
     *      ),
     *      @OA\Property(
     *          title="Heart Rate",
     *          property="heart_rate",
     *          description="Alumn's heart rate",
     *          format="int64",
     *          example="75"
     *      ),
     *      @OA\Property(
     *          title="Height",
     *          property="height",
     *          description="Alumn's height",
     *          format="decimal",
     *          example="1.79"
     *      ),
     *      @OA\Property(
     *          title="Weight",
     *          property="weight",
     *          description="Alumn's weight",
     *          format="decimal",
     *          example="80"
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
     *          description="Alumn's Street Address",
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
     *          title="Mobile Phone",
     *          property="mobile_phone",
     *          description="Mobile Phone",
     *          format="array", example="[+34424445456]"
     *      ),
     *      @OA\Property(
     *          title="Alumn's Image",
     *          property="image",
     *          description="Alumn's personal photograph or image",
     *          type="file"
     *      ),
     *      @OA\Property(
     *          title="Alumn's Mother Full Name",
     *          property="mother_full_name",
     *          description="Alumn's mother full name",
     *          format="string",
     *          example="Maria Ovalles"
     *      ),
     *      @OA\Property(
     *          title="Alumn's Mother Email",
     *          property="mother_email",
     *          description="Alumn's mother email",
     *          format="email",
     *          example="maria@anymail.com"
     *      ),
     *      @OA\Property(
     *          title="Mother Phone",
     *          property="mother_phone",
     *          description="Mother's Phone",
     *          format="array",
     *          example="['+34424445456']"
     *      ),
     *      @OA\Property(
     *          title="Mother Mobile Phone",
     *          property="mother_mobile_phone",
     *          description="Mother's Mobile Phone",
     *          format="array",
     *          example="[+34424445456]"
     *      ),
     *      @OA\Property(
     *          title="Alumn's Father Full Name",
     *          property="father_full_name",
     *          description="Alumn's Father full name",
     *          format="string",
     *          example="Maria Ovalles"
     *      ),
     *      @OA\Property(
     *          title="Alumn's Father Email",
     *          property="father_email",
     *          description="Alumn's Father email",
     *          format="email",
     *          example="maria@anymail.com"
     *      ),
     *      @OA\Property(
     *          title="Father Phone",
     *          property="father_phone",
     *          description="Father's Phone",
     *          format="array",
     *          example="['+34424445456']"
     *      ),
     *      @OA\Property(
     *          title="Father Mobile Phone",
     *          property="father_mobile_phone",
     *          description="Father's Mobile Phone",
     *          format="array",
     *          example="[+34424445456]"
     *      ),
     *      @OA\Property(
     *          title="Family Address' Country",
     *          property="family_address_country_id",
     *          description="Family's Address Country",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Family Address' Province",
     *          property="family_address_province_id",
     *          description="Family Address Province",
     *          format="int64",
     *          example="10"
     *      ),
     *      @OA\Property(
     *          title="Family Street Address",
     *          property="family_address_street",
     *          description="Alumn's Family Street Address",
     *          format="string",
     *          example="New York Alcoi"
     *      ),
     *      @OA\Property(
     *          title="Family Address City",
     *          property="family_address_city",
     *          description="Family's City",
     *          format="string",
     *          example="Madrid"
     *      ),
     *      @OA\Property(
     *          title="Family's Postal Code",
     *          property="family_address_postal_code",
     *          description="Family's Zip Code",
     *          format="string",
     *          example="33066"
     *      ),
     *      @OA\Property(
     *          title="Parents Marital Status Identificator",
     *          property="parents_marital_status_id",
     *          description="Identificator of parent's marital status",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Academical Emails",
     *          property="academical_emails",
     *          description="Academical email addresses as string separated by a comma",
     *          format="string",
     *          example="email1@test.com,email2@test.com"
     *      ),
     *      @OA\Property(
     *          title="Virtual Space",
     *          property="virtual_space",
     *          description="Virtual space related to the alumn",
     *          format="string",
     *          example="Example virtual space"
     *      ),
     *      @OA\Property(
     *          title="New Entry",
     *          property="is_new_entry",
     *          description="Used to determine if the alumn is from new entry",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Advanced Course",
     *          property="is_advanced_course",
     *          description="Used to determine if the alumn is from new advanced course",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Repeater",
     *          property="is_repeater",
     *          description="Used to determine if the alumn is a repeater",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Delegate",
     *          property="is_delegate",
     *          description="Used to determine if the alumn is a delegate",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Sub Delegate",
     *          property="is_sub_delegate",
     *          description="Used to determine if the alumn is a sub delegate",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Digital Difficulty",
     *          property="has_digital_difficulty",
     *          description="Used to determine if the alumn has any digital difficulty",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Acneae Sub Type Identificator",
     *          property="acneae_subtype_id",
     *          description="Identificator of related acneae subtype of alumn in case it's required",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Acneae Type Identificator",
     *          property="acneae_type_id",
     *          description="Identificator of related acneae type of alumn in case it's required",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Acneae Type Text",
     *          property="acneae_type_text",
     *          description="String representing the acneae type of alumn in case it's required",
     *          format="string",
     *          example="ADHD"
     *      ),
     *      @OA\Property(
     *          title="Acneae Description",
     *          property="acneae_description",
     *          description="Specifical description of alumn's acneae if needed",
     *          format="string",
     *          example="Has difficulties to concentrate"
     *      ),
     *      @OA\Property(
     *          title="Sport",
     *          property="has_sport",
     *          description="Used to determine if the alumn has any related sport",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Extracurricular Sport",
     *          property="has_extracurricular_sport",
     *          description="Used to determine if the alumn has any related extracurricular sport",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Federated Sport",
     *          property="has_federated_sport",
     *          description="Used to determine if the alumn has any related federated sport",
     *          format="boolean",
     *          example="false"
     *      ),
     *      @OA\Property(
     *          title="Favorite Sports",
     *          property="sports_played",
     *          description="Array of identificator of sports (3 maximum)",
     *          format="array",
     *          example="[1, 2, 3]"
     *      ),
     *  )
     */
    public function rules()
    {
        return [
            'full_name' => 'string|required',
            'list_number' => 'required',
            'gender_id' => 'required',
            'gender_identity_id' => 'nullable|integer',
            'email' => ['sometimes', 'email', new AlumnRelationEmail],
            'date_birth' => 'date',
            'country_id' => 'integer|exists:countries,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048',
            'mobile_phone' => ['nullable', 'string'],
            'phone' => ['nullable', 'string'],
            'mother_full_name' => 'string',
            'mother_email' => 'sometimes|email',
            'mother_mobile_phone' => ['nullable', 'string'],
            'mother_phone' => ['nullable', 'string'],
            'father_full_name' => 'string',
            'father_email' => 'sometimes|email',
            'father_mobile_phone' => ['nullable', 'string'],
            'father_phone' => ['nullable', 'string'],
            'family_address_street' => 'nullable|string',
            'family_address_postal_code' => 'nullable|string',
            'family_address_city' => 'nullable|string',
            'family_address_country_id' => 'integer|exists:countries,id',
            'family_address_province_id' => 'integer|exists:provinces,id',
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
