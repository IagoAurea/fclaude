<?php

namespace Modules\Fisiotherapy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFileRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateFileRequest",
     *   @OA\Property( title="Title", property="title", description="title", format="string", example="Ficha" ),
     *   @OA\Property( title="Anamnesis", property="anamnesis", description="anamnesis", format="string", example="Anamnesis" ),
     *   @OA\Property( title="Observation", property="observation", description="observation", format="string", example="Observation" ),
     *   @OA\Property( title="Has medication", property="has_medication", description="has_medication", format="boolean", example="true" ),
     *   @OA\Property( title="Medication", property="medication", description="medication", format="string", example="Medication" ),
     *   @OA\Property( title="Medication Objective", property="medication_objective", description="medication_objective", format="string", example="Medication objective" ),
     *   @OA\Property( title="Team staff", property="team_staff_id", description="team_staff_id", format="integer", example="1" ),
     *   @OA\Property( title="Injury", property="injury_id", description="injury_id", format="integer", example="1" ),
     *   @OA\Property( title="Has ended", property="has_ended", description="has_ended", format="boolean", example="true" )
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
            'title' => 'string|nullable',
            'specialty' => 'string|nullable',
            'anamnesis' => 'string|nullable',
            'observation' => 'string|nullable',
            'has_medication' => 'boolean|nullable',
            'medication' => 'string|nullable',
            'medication_objective' => 'string|nullable',
            'team_staff_id' => 'nullable|exists:staff_users,id',
            'injury_id' => 'nullable|exists:injuries,id',
            'has_ended' => 'nullable|boolean'
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
