<?php

namespace Modules\Player\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerInjuryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 
     *  @OA\Schema(
     *      schema="StorePlayerInjuryRequest",
     *      required={
     *          "injure_date",
     *          "injury_type_id"
     *      },
     *      @OA\Property(title="Injury date", property="injury_date", description="injury date", format="date", example="2021-10-21" ),
     *      @OA\Property(title="Mechanism injury", property="mechanism_injury_id", description="injury mechanism", format="int64", example="1" ),
     *      @OA\Property(title="Situation injury", property="injury_situation_id", description="injury situation", format="int64", example="1" ),
     *      @OA\Property(title="Is triggered by contac", property="is_triggered_by_contac", description="triggered by contac", format="boolean", example="true" ),
     *      @OA\Property(title="Type injury", property="injury_type_id", description="type of injury", format="int64", example="1" ),
     *      @OA\Property(title="Type spec injury", property="injury_type_spec_id", description="type spec of injury", format="int64", example="1" ),
     *      @OA\Property(title="Detailed diagnose", property="detailed_diagnose", description="detailed diagnose", format="string", example="Lorem ipsusssm" ),
     *      @OA\Property(title="Area body", property="area_body_id", description="area body", format="int64", example="1" ),
     *      @OA\Property(title="Detailed location", property="detailed_location", description="detailed location", format="string", example="More lorem ipsum" ),
     *      @OA\Property(title="Affected side", property="affected_side_id", description="affected side", format="int64", example="1" ),
     *      @OA\Property(title="Injury severity", property="injury_severity_id", description="injury severity", format="int64", example="1" ),
     *      @OA\Property(title="Relapse", property="is_relapse", description="is relapse", format="boolean", example="true" ),
     *      @OA\Property(title="Injury location", property="injury_location_id", description="injury location", format="int64", example="1" ),
     *      @OA\Property(title="Injury forecast", property="injury_forecast", description="injury forecast", format="string", example="More forecast lorem ipsum" ),
     *      @OA\Property(title="Days off", property="days_off", description="days off", format="int", example="20" ),
     *      @OA\Property(title="Matches off", property="matches_off", description="matches off", format="int", example="4" ),
     *      @OA\Property(title="Medically discharged date", property="medically_discharged_at", description="medically discharged date", format="date", example="2021-10-16" ),
     *      @OA\Property(title="Sportly discharged date", property="sportly_discharged_at", description="sportly discharged date", format="date", example="2021-11-21" ),
     *      @OA\Property(title="Competitively discharged date", property="competitively_discharged_at", description="competitively discharged date", format="date", example="2021-12-21" ),
     *      @OA\Property(title="Surgery date", property="surgery_date", description="surgery date", format="date", example="2021-10-21" ),
     *      @OA\Property(title="Surgeon name", property="surgeon_name", description="surgeon name", format="string", example="Dr. Jose Gregorio Hernandez" ),     
     *      @OA\Property(title="Medical center name", property="medical_center_name", description="medical center name", format="string", example="Dr. Jose Gregorio Hernandez" ),     
     *      @OA\Property(title="Surgery extra info", property="surgery_extra_info", description="surgery extra info", format="string", example="Surgery lorem ipsum information" ),     
     *      @OA\Property(title="Extra info", property="extra_info", description="extra info", format="string", example="extra information" ),     
     *      @OA\Property(title="Clinical test types", property="clinical_test_types", description="clinical test types", format="array", example="[1, 2, 3]" ),
     *      @OA\Property(title="Injury extrinsic factor", property="injury_extrinsic_factor", description="injury extrinsic factor", format="array", example="[1, 2, 3]" ),
     *      @OA\Property(title="Injury intrinsic factor", property="injury_intrinsic_factor", description="injury intrinsic factor", format="array", example="[1, 2, 3]" )
     *  )
     */
    public function rules()
    {
        return [
            'injury_date' => 'required|date',
            'mechanism_injury_id' => 'nullable|integer|exists:mechanisms_injury,id',
            'injury_situation_id' => 'nullable|integer|exists:injury_situations,id',
            'is_triggered_by_contact' => 'nullable|boolean',
            'injury_type_id' => 'required|integer|exists:injury_types,id',
            'injury_type_spec_id' => 'required|integer|exists:injury_type_specs,id',
            'detailed_diagnose' => 'nullable|string',
            'area_body_id' => 'required|integer|exists:areas_body,id',
            'detailed_location' => 'nullable|string',
            'affected_side_id' => 'nullable|integer',
            'is_relapse' => 'nullable|boolean',
            'injury_severity_id' => 'nullable|integer|exists:injury_severities,id',
            'injury_location_id' => 'nullable|integer|exists:injury_locations,id',
            'injury_forecast' => 'nullable|string',
            'days_off' => 'nullable|integer',
            'matches_off' => 'nullable|integer',
            'medically_discharged_at' => 'nullable|date',
            'sportly_discharged_at' => 'nullable|date',
            'competitively_discharged_at' => 'nullable|date',
            'surgery_date' => 'nullable|date',
            'surgeon_name' => 'nullable|string',
            'medical_center_name' => 'nullable|string',
            'surgery_extra_info' => 'nullable|string',
            'extra_info' => 'nullable|string',
            'clinical_test_types' => 'nullable|array',
            'clinical_test_types.*' => 'integer|exists:clinical_test_types,id',
            'injury_intrinsic_factor' => 'nullable|array',
            'injury_intrinsic_factor.*' => 'integer|exists:injury_intrinsic_factors,id',
            'injury_extrinsic_factor' => 'nullable|array',
            'injury_extrinsic_factor.*' => 'integer|exists:injury_extrinsic_factors,id'
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
