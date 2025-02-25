<?php

namespace Modules\Player\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerSkillsRequest extends FormRequest
{
    
     /**
     * @OA\Schema(
     *   schema="StorePlayerSkillsRequest",
     *   @OA\Property( title="Skills", property="skills", description=" ", format="array", example=" [{'punctuation_id' : 3,'skills_id': 1},{'punctuation_id' : 3,'skills_id': 2}]" )
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
            'skills.*.punctuation_id' => 'required|exists:punctuations,id',
            'skills.*.skills_id' => 'required||exists:skills,id'
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
