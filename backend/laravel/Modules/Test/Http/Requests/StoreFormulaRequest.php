<?php

namespace Modules\Test\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormulaRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreFormulaRequest",
     *   @OA\Property( title="Test", property="test_id", description="test related ", format="integer", example="1" ),
     *   @OA\Property( title="Formulas", property="formulas", description="formulas", format="application/json", example="[{'params':[{'param' : 1,'name': 'peso','question_responses_id':  1},{'param' : 2,'name': 'peso','question_responses_id':  1}],'formula':{'name': 'calcular masa','description':'es una formula de ejemplo que no es cierta','formula': '$1 * $2 /10'} }]"),
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
            'formulas' => 'required|array',
            'formulas.*.params' => 'required|array',
            'formulas.*.params.*.param' => 'required|integer',
            'formulas.*.params.*.name' => 'required|string',
            'formulas.*.params.*.question_responses_id' => 'required|integer|exists:question_responses,id',
            'formulas.*.formula' => 'required',
            'formulas.*.formula.name' => 'required|string',
            'formulas.*.formula.description' => 'required|string',
            'formulas.*.formula.formula' => 'required|string'
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
