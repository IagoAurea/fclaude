<?php

namespace Modules\Fisiotherapy\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyWorkRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="FisiotherapyUpdateDailyWorkRequest",
     *   @OA\Property( title="Duration minutes", property="minutes_duration", description="duration minutes ", format="integer", example="10" ),
     *   @OA\Property( title="Sensations", property="sensations", description="sensations", format="string", example="Multiple testing sensations" ),
     *   @OA\Property( title="Exploration", property="exploration", description="exploration", format="string", example="A custom exploration" ),
     *   @OA\Property( title="Tests", property="tests", description="tests", format="string", example="A custom test" ),
     *   @OA\Property( title="Observation", property="observation", description="observation", format="string", example="A custom observation" ),
     *   @OA\Property( title="Date Daily Work", property="work_date", description="work_date", format="date", example="2022-08-23" ),
     *   @OA\Property( title="Treatments", property="treatments", description="treatments", format="array", example="[1, 2, 3]" )
     * )
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'minutes_duration' => 'required|integer',
            'sensations' => 'string|nullable',
            'exploration' => 'string|nullable',
            'tests' => 'string|nullable',
            'observations' => 'string|nullable',
            'work_date' => 'required|date',
            'treatments' => 'required|array',
            'treatments.*' => 'exists:treatments,id',
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
