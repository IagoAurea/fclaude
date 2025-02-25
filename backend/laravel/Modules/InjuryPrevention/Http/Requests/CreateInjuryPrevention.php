<?php

namespace Modules\InjuryPrevention\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateInjuryPrevention extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     *  @OA\Schema(
     *      schema="CreateInjuryPreventionRequest",
     *      type="object",
     *      required={
     *          "title",
     *          "detailed_location",
     *          "description",
     *          "team_staff_id",
     *          "preventive_program_type_id",
     *          "injury_location_id"
     *      },
     *      @OA\Property(property="title", format="string", example="First Prevention Program"),
     *      @OA\Property(property="detailed_location", format="string", example="Upper bracket heading"),
     *      @OA\Property(property="description", format="string", example="Program description"),
     *      @OA\Property(property="team_staff_id", format="int64", example="1"),
     *      @OA\Property(property="preventive_program_type_id", format="int64", example="1"),
     *      @OA\Property(property="injury_location_id", format="int64", example="1"),
     *      @OA\Property(property="week_days", format="array", example="[1, 2, 3]"),
     *      @OA\Property(property="other_preventive_program_type", format="string", example="Other case"),
     * )
     */
    public function rules()
    {
        return [
            'title'             => 'string|required',
            'detailed_location' => 'string|required',
            'description'       => 'string|required',
            'team_staff_id'     => 'required|exists:staff_users,id',
            'preventive_program_type_id' => 'required|exists:preventive_program_types,id',
            'injury_location_id' => 'required|exists:injury_locations,id',
            'week_days'         =>  'array|required',
            'week_days.*'       =>  'integer',
            'other_preventive_program_type' => 'nullable|string'
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
