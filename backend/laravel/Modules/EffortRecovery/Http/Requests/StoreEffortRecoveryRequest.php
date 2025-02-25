<?php

namespace Modules\EffortRecovery\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEffortRecoveryRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     * @OA\Schema(
     *  schema="StoreEffortRecoveryRequest",
     *  type="object",
     *  @OA\Property(
     *      property="has_trategy",
     *      type="boolean",
     *      example="true",
     *  ), 
     *  @OA\Property(
     *      property="effort_recovery_strategy_ids",
     *      format="array",
     *      example="[1, 2, 3]",
     *  )
     * )
     */
    public function rules()
    {
        return [
            'has_strategy' => 'nullable|boolean',
            'effort_recovery_strategy_ids' => 'nullable|array',
            'effort_recovery_strategy_ids.*' => 'exists:effort_recovery_strategies,id'
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
