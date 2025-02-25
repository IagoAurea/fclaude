<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseSessionEffortAssessmentRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *   schema="StoreExerciseSessionEffortAssessmentRequest",
     *      @OA\Property( title="Assistance", property="assistance_id", description="assistanse associate", format="integer", example="1" ),
     *      @OA\Property( title="Subjetive Percept", property="subjec_percept_effort_id", description="perception of effort", format="integer", example="1" ),     
     *      @OA\Property( title="Hear Rate", property="hear_rates", description="table hear rate associate", format="application/json", example="{'max_heart_rate':80,'mean_heart_rate':60,'min_heart_rate':30,'variability_heart_rate':3,'vo2max':3}" ),     
     *      @OA\Property( title="Gps", property="gps", description="table gps associate", format="application/json", example="{'total_distance_traveled':15,'number_sprints':3,'distance_sprint':5,'max_speed':50,'metabolic_potency':20,'high_speed_race':5,'slowdowns':1,'accelerations':3}" ),    
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
            'assistance_id' => 'required|integer|exists:exercise_session_assistances,id',
            'subjec_percept_effort_id' => 'required|integer|exists:subjec_percept_efforts,id',
            'hear_rates.max_heart_rate' => 'numeric|max:999',
            'hear_rates.mean_heart_rate' => 'numeric|max:999',
            'hear_rates.min_heart_rate' => 'numeric|max:999',
            'hear_rates.variability_heart_rate' => 'numeric|max:999',
            'hear_rates.vo2max' => 'numeric|max:999',
            'gps.total_distance_traveled' => 'numeric|max:999',
            'gps.number_sprints' => 'integer|max:9999',
            'gps.distance_sprint' => 'numeric|max:999',
            'gps.max_speed' => 'numeric|max:999',
            'gps.metabolic_potency' => 'integer|max:9999',
            'gps.high_speed_race' => 'numeric|max:999',
            'gps.slowdowns' => 'integer|max:9999',
            'gps.accelerations' => 'integer|max:9999',
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
