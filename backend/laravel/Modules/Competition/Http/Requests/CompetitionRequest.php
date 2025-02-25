<?php


namespace Modules\Competition\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CompetitionRequest extends FormRequest
{
     /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     *  @OA\Schema(
     *      schema="StoreCompetitionRequest",
     *      @OA\Property(title="Competition Name", property="name", description="competition name", format="string", example="John Doe"),
     *      @OA\Property(title="Team", property="team_id", description="team", format="int64", example="1"),
     *      @OA\Property(title="Type Competition", property="type_competition_id", description="type competition", format="int64", example="1"),
     *      @OA\Property(title="Start Date", property="date_start", description="starting's date of competition", type="date", example="2022-05-20"),
     *      @OA\Property(title="End Date", property="date_end", description="ending's date of competition", type="date", example="2022-05-30"),
     *      @OA\Property(title="Competition Image", property="image", description="competition photograph or main image", type="file"),
     *      
     *  )
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3',
            'team_id' => 'required|integer|exists:teams,id',
            'type_competition_id' => 'required|integer|exists:type_competitions,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|min:1|max:2048'
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
