<?php

namespace Modules\Club\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClubInvitationRequest extends FormRequest
{
    /**
     * Validations rules applied to the request
     * @return array
     *
     * @OA\Schema(
     *  schema="StoreClubInvitationRequest",
     *  type="object",
     *  @OA\Property(title="Club", property="club_id", description="club associate", type="integer", example="1"),
     *  @OA\Property(title="Annotation", property="annotation", description="annotation", type="integer", example="Data test"),
     *  @OA\Property(
     *      property="invited_users",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="email", type="email", example="user@example.com"),
     *          @OA\Property(
     *              property="teams",
     *              format="array",
     *              type="array",
     *              @OA\Items(type="number", format="int32")
     *          ),
     *          @OA\Property(
     *              property="permissions_list",
     *              format="array",
     *              type="array",
     *              @OA\Items(type="string")
     *          ),
     *      ),
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'club_id'   => 'required|exists:clubs,id',
            'annotation' => 'nullable|string',
            'invited_users'    =>  'required|array',
            'invited_users.*.email'  =>  'required|string|email',
            'invited_users.*.teams'  =>  'nullable|array',
            'invited_users.*.permissions_list' =>'nullable|array'
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
