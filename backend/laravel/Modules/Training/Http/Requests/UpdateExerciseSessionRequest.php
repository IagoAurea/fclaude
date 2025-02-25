<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseSessionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     *
     * @OA\Schema(
     *  schema="UpdateExerciseSessionRequest",
     *  @OA\Property(
     *      property="author",
     *      format="string",
     *      example="string"
     *  ),
     *  @OA\Property(
     *      property="title",
     *      format="string",
     *      example="string"
     *  ),
     *  @OA\Property(
     *      property="icon",
     *      description="identifier icon",
     *      format="file",
     *      example=""
     *  ),
     *  @OA\Property(
     *      property="difficulty",
     *      format="double",
     *      example="5"
     *  ),
     *  @OA\Property(
     *      property="intensity",
     *      description="session intensity",
     *      example="3"
     *  ),
     *  @OA\Property(
     *      property="duration",
     *      format="string",
     *      example="10:00"
     *  ),
     *  @OA\Property(
     *      property="number_exercises",
     *      format="integer",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="materials",
     *      format="integer",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="type_exercise_session_id",
     *      format="integer",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="training_period_id",
     *      format="integer",
     *      example="1"
     *  ),
     *  @OA\Property(
     *      property="targets",
     *      format="array",
     *      example="[1,2,3]"
     *  ),
     *  @OA\Property(
     *      property="execution",
     *      format="object",
     *      @OA\Property(
     *          property="date_session",
     *          format="date",
     *          example="2020-01-01"
     *      ),
     *      @OA\Property(
     *          property="hour_session",
     *          format="string",
     *          example="20:30"
     *      ),
     *      @OA\Property(
     *          property="place_session",
     *          format="string",
     *          example="string"
     *      ),
     *      @OA\Property(
     *          property="observation",
     *          format="string",
     *          example="string"
     *      ),
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'author' => 'required|string',
            'title' => 'required|string',
            'difficulty' => 'numeric|max:5',
            'intensity' => 'numeric|max:5',
            'duration' => 'required|string|max:99999',
            'number_exercises' => 'numeric|max:999',
            'type_exercise_session_id' => 'required',
            'training_period_id' => 'required',
            'execution' => 'required',
            'execution.date_session' => 'date',
            'execution.hour_session' => 'string|max:5',
            'execution.place_session' => 'string|max:255',
            'execution.exercise_session_place_id' => 'integer|exists:exercise_session_places,id'
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
