<?php

namespace Modules\Injury\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInjuryRfdRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="UpdateInjuryRfdRequest",
     *   @OA\Property( title="Annotations", property="annotations", description="Observations", format="string", example="New annotations" ),
     *   @OA\Property( title="Criterias", property="criterias", description="criterias update", format="application/json", example="[{'id':1,'value': true}]" )
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
            'annotations'        => 'nullable|string',
            'criterias'          => 'nullable|array',
            'criterias.*.id'     => 'required|exists:injury_rfd_criterias,id',
            'criterias.*.value'  => 'nullable|boolean',
            'team_id'            => 'required|integer|exists:teams,id'
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
