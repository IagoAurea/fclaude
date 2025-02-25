<?php

namespace Modules\Competition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompetitionRivalTeamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 
     * @OA\Schema(
     *      schema="UpdateCompetitionRivalTeamRequest",
     *      @OA\Property(title="Rival Teams", property="rival_teams", description="Rival teams", format="array", example="[{'id': 1, 'name':'Team 1','image': 'file binary'},{'id': 2, 'name':'Team 1','image': 'file binary'}"),
     *
     *  )
     */
    public function rules()
    {
        return [
            'rival_teams' => 'required|array',
            'rival_teams.*.id' => 'required|integer|exists:competition_rival_teams,id',
            'rival_teams.*.name' => 'required|string',
            'rival_teams.*.image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048'
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
