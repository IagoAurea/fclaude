<?php


namespace Modules\Competition\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CompetitionMatchRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     * @OA\Schema(
     *  schema="CreateCompetitionMatchRequest",
     *  type="object",
     *  required={
     *      "competition_id",
     *      "start_at",
     *      "competition_rival_team_id",
     *      "match_situation",
     *  },
     *  @OA\Property(property="competition_id", format="int64", example="1"),
     *  @OA\Property(property="start_at", format="string", example="2022-01-01"),
     *  @OA\Property(property="location", format="string", example="Program location"),
     *  @OA\Property(property="observation", format="string", example="Program lane swimming"),
     *  @OA\Property(property="competition_rival_team_id", format="int64", example="1"),
     *  @OA\Property(property="match_situation", format="string", example="L"),
     *  @OA\Property(property="referee_id", format="int64", example="1"),
     *  @OA\Property(property="weather_id", format="int64", example="1"),
     *  @OA\Property(property="modality_id", format="int64", example="1"),
     *  @OA\Property(property="test_category_id", format="int64", example="1"),
     *  @OA\Property(property="test_type_category_id", format="int64", example="1"),
     *  @OA\Property(
     *      property="lineup",
     *      format="object",
     *      @OA\Property(property="type_lineup_id", format="int64", example="1"),
     *      @OA\Property(
     *          property="players",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(property="player_id", format="int64", example="1"),
     *              @OA\Property(property="lineup_player_type_id", format="int64", example="1"),
     *              @OA\Property(property="order", format="int64", example="1")
     *          ),
     *      ),
     *  ),
     *  @OA\Property(property="rivals", format="array", example="['Jose Perez', 'Pedro Jimenez']"),
     *  @OA\Property(property="players", format="array", example="[1, 2]"),
     * )
     */
    public function rules()
    {
        return [
            'team_id' => 'required|integer|exists:teams,id',
            'competition_id' => 'required|integer|exists:competitions,id',
            'start_at' => 'required|date',
            'location' => 'nullable|string',
            'competition_rival_team_id' => 'nullable|integer|exists:competition_rival_teams,id',
            'match_situation' => 'nullable|string|max:1',
            'referee_id' => 'nullable|integer',
            'weather_id' => 'nullable|integer',
            'observation' => 'nullable|string',
            'modality_id' => 'integer|exists:type_modalities_match,id',
            'test_category_id' => 'nullable|integer|exists:test_categories_match,id',
            'test_type_category_id' => 'nullable|integer|exists:test_type_categories_match,id',
            'lineup' => 'sometimes|nullable',
            'lineup.type_lineup_id' => 'integer|exists:type_lineups,id',
            'lineup.players' => 'required_if:lineup,present|array',
            'lineup.players.*.player_id' => 'required_if:lineup.players.*,present|integer|exists:players,id',
            'lineup.players.*.lineup_player_type_id' => 'integer|exists:lineup_player_types,id',
            'lineup.players.*.order' => 'nullable|integer',
            'rivals' => 'sometimes|array',
            'rivals.*' => 'required|string|distinct|min:2',
            'players' => 'sometimes|array',
            'players.*' => 'required|integer|exists:players,id'
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
