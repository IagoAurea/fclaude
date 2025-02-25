<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkGroupRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreWorkGroupRequest",
     *   @OA\Property( title="Name", property="name", description="name group ", format="string", example="Name" ),
     *   @OA\Property( title="Description", property="description", description="description group ", format="string", example="Description" ),
     *   @OA\Property( title="Color", property="color", description="color group ", format="string", example="Color" ),
     *   @OA\Property( title="Players", property="players", description="players associate", format="array", example="[6,7,8]" ),
     *   @OA\Property( title="Alumns", property="alumns", description="alumns associate", format="array", example="[6,7,8]" ),
     *   @OA\Property( title="Exercise session", property="exercise_session_id", description="exercise session associate", format="integer", example="1" ),
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
            'name' => 'required|string',
            'color' => 'nullable|string',
            'description' => 'nullable|string',
            'players' => 'required_without:alumns|array',
            'players.*' => 'required|integer|exists:players,id',
            'alumns' => 'required_without:players|array',
            'alumns.*' => 'required|integer|exists:alumns,id',
            'exercise_session_id' => 'required|exists:exercise_sessions,id'
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
