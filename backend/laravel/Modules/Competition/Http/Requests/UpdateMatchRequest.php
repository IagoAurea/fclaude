<?php

namespace Modules\Competition\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     * @OA\Schema(
     *  schema="UpdateMatchRequest",
     *  type="object",
     *  @OA\Property(
     *      property="competition_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="start_at",
     *      format="string",
     *      example="2022-01-01"
     *  ),
     *  @OA\Property(
     *      property="location",
     *      format="string",
     *      example="Program location"
     *  ),
     *  @OA\Property(
     *      property="competition_rival_team_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="match_situation",
     *      format="string",
     *      example="L"
     *  ),
     *  @OA\Property(
     *      property="referee_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="weather_id",
     *      format="int64",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="lineup",
     *      format="object",
     *      @OA\Property(
     *          property="type_lineup_id",
     *          format="int64",
     *          example="1",
     *      ),
     *      @OA\Property(
     *          property="players",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="player_id", format="int64", example="1"),
     *              @OA\Property(property="lineup_player_type_id", format="int64", example="1"),
     *              @OA\Property(property="order", format="int64", example="1"),
     *              @OA\Property(property="perception_effort_id", format="int64", example="1")
     *          ),
     *      ),
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'competition_id' => 'required|integer|exists:teams,id',
            'competition_id' => 'nullable|integer|exists:competitions,id',
            'start_at' => 'nullable|date',
            'location' => 'nullable|string',
            'competition_rival_team_id' => 'nullable|integer|exists:competition_rival_teams,id',
            'match_situation' => 'nullable|string|max:1',
            'referee_id' => 'nullable|integer',
            'weather_id' => 'nullable|integer',
            'lineup' => 'nullable',
            'lineup.type_lineup_id' => 'integer|exists:type_lineups,id',
            'lineup.players' => 'nullable|array',
            'lineup.players.*.player_id' => 'integer|exists:players,id',
            'lineup.players.*.lineup_player_type_id' => 'integer|exists:lineup_player_types,id',
            'lineup.players.*.order' => 'integer',
            'lineup.players.*.perception_effort_id' => 'integer|exists:subjec_percept_efforts,id',
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
