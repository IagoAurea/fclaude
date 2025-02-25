<?php

namespace Modules\Injury\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInjuryRfdRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreInjuryRfdRequest",
     *   @OA\Property( title="Injury", property="injury_id", description=" injury related ", format="integer", example="1" ),
     *   @OA\Property( title="Annotations", property="annotations", description="Observations", format="string", example="New annotations"),
     *   @OA\Property( title="Team", property="team_id", description="team related ", format="integer", example="1" )
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
            'injury_id' => 'required|exists:injuries,id',
            'annotations' => 'nullable|string',
            'team_id' => 'required|integer|exists:teams,id'
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
