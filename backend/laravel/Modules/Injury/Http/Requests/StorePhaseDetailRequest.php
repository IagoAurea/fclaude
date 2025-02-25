<?php

namespace Modules\Injury\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePhaseDetailRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StorePhaseDetailRequest",
     *   @OA\Property( title="Professional directs", property="professional_directs_id", description="professional related ", format="integer", example="1" ),
     *   @OA\Property( title="Test Passed", property="test_passed", description="indicator test passed", format="boolean", example="true" ),
     *   @OA\Property( title="Not Pain", property="not_pain", description="indicator pain", format="boolean", example="true" ),
     *   @OA\Property( title="Answers", property="answers", description="answers to test", format="array", example="[{'id':46,'text': 'text response','unit_id':1},{'id':51,'text': '','unit_id':1}]" ),     
     *   @OA\Property( title="Date Application", property="date_application", description="", format="date", example="2021-12-01" ),     
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
            'professional_directs_id' => 'nullable|exists:staff_users,id',
            'test_passed' => 'nullable|boolean',
            'not_pain'         => 'nullable|boolean',
            'answers'    => 'required|array',
            'date_application'         => 'required|date'
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
