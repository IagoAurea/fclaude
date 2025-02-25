<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestApplicationRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreTestApplicationRequest",
     *   @OA\Property( title="Test", property="test_id", description="Test applied", format="integer", example="1" ),
     *   @OA\Property( title="Entity", property="entity_name", description="Name to entity", format="string", example="rfd" ),
     *   @OA\Property( title="Answers", property="answers", description="answers to test", format="array", example="[{'id':46,'text': 'text response','unit_id':1},{'id':51,'text': '','unit_id':1}]" ),     
     *   @OA\Property( title="Date Application", property="date_application", description="", format="date", example="2021-12-01" ),     
     *   @OA\Property( title="Player", property="player_id", description="player associate (send either player_id or alumn_id)", format="integer", example="1" ),     
     *   @OA\Property( title="Alumn", property="alumn_id", description="alumn associate (send either player_id or alumn_id)", format="integer", example="1" ),     
     *   @OA\Property( title="Profesional Direct", property="professional_directs_id", description="", format="integer", example="1" ),     
     * 
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
            'test_id' => 'required|integer|exists:tests,id',
            'entity_name' => 'required|string',
            'answers' =>  'required|array',
            'date_application' =>  'required|date',
            'player_id' => 'exists:players,id',
            'alumn_id' => 'exists:alumns,id',
            'professional_directs_id' => 'required|exists:staff_users,id',
            'team_id' => 'required_if:player_id,present|integer|exists:teams,id'
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
