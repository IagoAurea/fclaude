<?php

namespace Modules\InjuryPrevention\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInjuryPrevention extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     *  @OA\Schema(
     *      schema="UpdateInjuryPreventionRequest",
     *      type="object",
     *      @OA\Property(
     *          property="title",
     *          type="string",
     *          example="Updating Program"
     *      ),
     *      @OA\Property(
     *          property="detailed_location",
     *          type="string",
     *          example="Upper bracket heading update"
     *      ),
     *      @OA\Property(
     *          property="description",
     *          type="string",
     *          example="Program description update"
     *      ),
     *      @OA\Property(
     *          property="team_staff_id",
     *          type="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          property="preventive_program_type_id",
     *          type="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          property="injury_location_id",
     *          type="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          property="week_days",
     *          format="array",
     *          example="[4, 5]"
     *      ),
     * )
     */
    public function rules()
    {
        return [
            'title'             => 'string',
            'detailed_location' => 'string',
            'description'       => 'string',
            'team_staff_id'     => 'exists:staff_users,id',
            'preventive_program_type_id' => 'exists:preventive_program_types,id',
            'injury_location_id' => 'exists:injury_locations,id',
            'week_days'         =>  'array',
            'week_days.*'       =>  'integer',
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
