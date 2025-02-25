<?php


namespace Modules\Competition\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CompetitionMatchLineupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'competition_match_id' => 'required|integer|exists:competition_matches,id',
            'type_lineup_id' => 'required|integer|exists:type_lineups,id',
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
