<?php

namespace Modules\Competition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompetitionRivalTeamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     *  @OA\Schema(
     *      schema="CompetitionRivalTeamRequest",
     *      @OA\Property(title="Competition ID", property="competition_id", description="competition Id", format="integer", example="1"),
     *      @OA\Property(title="Rival Teams", property="rival_teams", description="Rival teams", format="array", example="[{'name':'Team 1','image': 'file binary'},{'name':'Team 1','image': 'file binary'}"),
     *
     *  )
     */
    public function rules()
    {
        return [
            'competition_id' => 'required|integer|exists:competitions,id',
            'rival_teams' => 'required|array',
            'rival_teams.*.name' => 'required|string',
            'rival_teams.*.image' => 'nullable|base64image|base64max:2048',
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
