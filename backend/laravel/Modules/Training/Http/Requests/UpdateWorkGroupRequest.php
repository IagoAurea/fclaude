<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkGroupRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateWorkGroupRequest",
     *   @OA\Property( title="Name", property="name", description="name group ", format="string", example="Name" ),
     *   @OA\Property( title="Color", property="color", description="color group ", format="string", example="AAAAAA" ),
     *   @OA\Property( title="Description", property="description", description="description group ", format="string", example="description" ),
     *   @OA\Property( title="Players", property="players", description="players associate", format="array", example="[6,7,8]" ),
     *   @OA\Property( title="Alumns", property="alumns", description="alumns associate", format="array", example="[6,7,8]" ),
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
            'alumns.*' => 'required|integer|exists:alumns,id'
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
