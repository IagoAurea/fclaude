<?php

namespace Modules\Club\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvitationPermissionsRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateInvitationPermissionsRequest",
     *      @OA\Property( title="Permissions", property="permissions", description="permissions associate", format="array", example="['club_team_read','club_team_store','team_competition_read','team_exercise_delete']" ),
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
            'permissions'     => 'required|array',
            'permissions.*'   => 'required|exists:permissions,name',
        
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
