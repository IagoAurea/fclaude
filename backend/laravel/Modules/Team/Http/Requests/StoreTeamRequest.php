<?php

namespace Modules\Team\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreTeamRequest",
     *   @OA\Property( title="Name", property="name", description="name by team", format="string", example="Nuevo equipo" ),
     *   @OA\Property( title="Category", property="category", description="category", format="string", example="categoria" ),
     *   @OA\Property( title="Color", property="color", description="color by team", format="regex:/^#([A-Fa-f0-9]{6})$/", example="#FB6B26" ),
     *   @OA\Property( title="Type", property="type_id", description="type associate", format="integer", example="1" ),
     *   @OA\Property( title="Modality", property="modality_id", description="modality associate", format="integer", example="1" ),
     *   @OA\Property( title="Season", property="season_id", description="season associate", format="integer", example="1" ),
     *   @OA\Property( title="Gender", property="gender_id", description="gender associate", format="integer", example="1" ),
     *   @OA\Property( title="Sport", property="sport_id", description="sport associate", format="integer", example="1" ),
     *   @OA\Property( title="Club", property="club_id", description="Club associate", format="integer", example="1" ),
     *   @OA\Property( title="Image", property="image", description="image by team", format="file", example="" ),
     *   @OA\Property( title="Cover", property="cover", description="cover by team", format="file", example="" )
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
            'name' => 'required|string|min:3',
            'category' => 'required|string|min:3',
            'color' => 'nullable|regex:/^#([A-Fa-f0-9]{6})$/',
            'type_id' => 'nullable|integer|exists:team_type,id',
            'modality_id' => 'nullable|integer|exists:team_modality,id',
            'season_id' => 'required|integer|exists:seasons,id',
            'gender_id' => 'nullable|integer',
            'sport_id' => 'required|integer|exists:sports,id',
            'club_id' => 'required|integer|exists:clubs,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|dimensions:min_width=250,min_height=250|min:1|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,svg|dimensions:min_width=250,min_height=250|min:1|max:2048'
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
