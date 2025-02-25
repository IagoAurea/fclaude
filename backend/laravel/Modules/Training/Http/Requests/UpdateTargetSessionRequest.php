<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTargetSessionRequest extends FormRequest
{
     /**
     * @OA\Schema(
     *   schema="UpdateTargetSessionRequest",
     *   @OA\Property( title="Name in Spanish", property="name_spanish", description="sub content name in spanish ", format="string", example="Nuevo target" ),
     *   @OA\Property( title="Name in English", property="name_english", description="sub content name in English", format="string", example="New target" ),
     *   @OA\Property( title="Content exercise", property="content_exercise_id", description="content associate", format="integer", example="1" ),
     *   @OA\Property( title="Sub content session", property="sub_content_session_id", description="sub content associate", format="integer", example="1" ),
     *   @OA\Property( title="Sport", property="sport_id", description="sport associate", format="integer", example="1" ),
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
            'name_spanish' => 'required|string',
            'name_english' => 'required|string',
            'content_exercise_id' => 'required',
            'sub_content_session_id'  => 'required',
            'sport_id' => 'required',
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
