<?php

namespace Modules\Player\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Custom Validation Rules
use Modules\Generality\Rules\StringArray;
use Modules\Player\Rules\PlayerRelationEmail;

class StorePlayerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     *  @OA\Schema(
     *      schema="StorePlayerRequest",
     *      @OA\Property(title="Player Full Name", property="full_name", description="Player's full name", format="string", example="John Doe"),
     *      @OA\Property(title="Email", property="email", description="Email", format="email", example="user@example.com"),
     *      @OA\Property(title="Player Alias", property="alias", description="Player alias", format="string", example="Chicharito"),
     *      @OA\Property(title="Position Identification", property="position_id", description="Identificator of position related to the player", format="int64", example="1"),
     *      @OA\Property(title="Position Specific Identification", property="position_spec_id", description="Identificator of position specification depending on the previous position_id", format="int64", example="1" ),
     *      @OA\Property(title="Position Identification Text", property="position_text", description="Position related to the player case other", format="string", example="postion alternate"),
     *      @OA\Property(title="Position Specific Text", property="position_spec_text", description="Position specification depending on the previous position case other", format="string", example="position specification alternate" ),
     *      @OA\Property(title="Team Identification", property="team_id", description="Identificator of player's team", format="int64", example="1"),
     *      @OA\Property(title="Shirt number", property="shirt_number", description="Shirt number of player's team", format="int64", example="1"),
     *      @OA\Property(title="Laterality Identification", property="laterality_id", description="Identificator of player's laterality", format="int64", example="1"),
     *      @OA\Property(
     *          title="Gender Identification",
     *          property="gender_id",
     *          description="Identificator of player's gender",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Gender Identity Identification",
     *          property="gender_identity_id",
     *          description="Identificator of player's gender identity",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          title="Date Birth",
     *          property="date_birth",
     *          description="Birthdate of the player",
     *          format="string",
     *          example="2000-10-01"
     *      ),
     *      @OA\Property(
     *          title="Heart Rate",
     *          property="heart_rate",
     *          description="Player's heart rate",
     *          format="int64",
     *          example="75"
     *      ),
     *      @OA\Property(
     *          title="Height",
     *          property="height",
     *          description="Player's height",
     *          format="decimal",
     *          example="1.79"
     *      ),
     *      @OA\Property(
     *          title="Weight",
     *          property="weight",
     *          description="Player's weight",
     *          format="decimal",
     *          example="80"
     *      ),
     *      @OA\Property(
     *          title="Agents",
     *          property="agents",
     *          description="Player related agents",
     *          format="string",
     *          example="Agents"
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
     *          description="Player's Street Address",
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
     *          title="Profile",
     *          property="profile",
     *          description="Profile Characteristic player",
     *          format="string", example="Player"
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
     *          title="Player's Image",
     *          property="image",
     *          description="Player's personal photograph or image",
     *          type="file"
     *      ),
     *      @OA\Property(
     *          title="Player's Mother Full Name",
     *          property="mother_full_name",
     *          description="Player's mother full name",
     *          format="string",
     *          example="Maria Ovalles"
     *      ),
     *      @OA\Property(
     *          title="Player's Mother Email",
     *          property="mother_email",
     *          description="Player's mother email",
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
     *          title="Player's Father Full Name",
     *          property="father_full_name",
     *          description="Player's Father full name",
     *          format="string",
     *          example="Maria Ovalles"
     *      ),
     *      @OA\Property(
     *          title="Player's Father Email",
     *          property="father_email",
     *          description="Player's Father email",
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
     *          description="Player's Family Street Address",
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
     *  )
     */
    public function rules()
    {
        return [
            'full_name' => 'string|required',
            'alias' => 'string|required',
            'gender_id' => 'nullable|integer',
            'gender_identity_id' => 'nullable|integer',
            'email' => ['sometimes', 'email', new PlayerRelationEmail],
            'date_birth' => 'nullable|date',
            'position_id' => 'nullable|exists:sports_positions,id',
            'position_spec_id' => 'nullable|exists:sports_positions_specs,id',
            'position_text' => 'nullable|string',
            'position_spec_text' => 'nullable|string',
            'team_id' => 'required|exists:teams,id',
            'shirt_number' => 'required|numeric',
            'agents' => 'nullable|string',
            'mobile_phone' => ['nullable', 'string', new StringArray],
            'phone' => ['nullable', 'string', new StringArray],
            'mother_full_name' => 'string',
            'mother_email' => 'sometimes|email',
            'mother_mobile_phone' => ['nullable', 'string', new StringArray],
            'mother_phone' => ['nullable', 'string', new StringArray],
            'father_full_name' => 'string',
            'father_email' => 'sometimes|email',
            'father_mobile_phone' => ['nullable', 'string', new StringArray],
            'father_phone' => ['nullable', 'string', new StringArray],
            'family_address_street' => 'nullable|string',
            'family_address_postal_code' => 'nullable|string',
            'family_address_city' => 'nullable|string',
            'family_address_country_id' => 'integer|exists:countries,id',
            'family_address_province_id' => 'integer|exists:provinces,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048',
            'profile' => 'nullable|string'
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
