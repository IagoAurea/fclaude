<?php

namespace Modules\Injury\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyWorkRequest extends FormRequest
{
     /**
     * @OA\Schema(
     *   schema="UpdateDailyWorkRequest",
     *   @OA\Property( title="Day", property="day", description="date of work ", format="date", example="2021-10-21" ),
     *   @OA\Property( title="Duration", property="duration", description="duration of work", format="string", example="05:00" ),
     *   @OA\Property( title="Rpe", property="rpe", description="evaluation rpe", format="integer", example="10" ),
     *   @OA\Property( title="Test", property="test", description="tests performed", format="string", example="Dancing" ),     
     *   @OA\Property( title="Description", property="description", description="description to daily work", format="string", example="this is a description" ),
     *   @OA\Property( title="Rfd", property="injury_rfd_id", description="rfd associate", format="integer", example="1" )
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
            'day' => 'required|date',
            'duration' => 'required|string',
            'rpe' => 'required|integer',
            'test'          => 'nullable|string',
            'description' => 'required|string',
            'injury_rfd_id' => 'required|integer|exists:injury_rfds,id',
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
