<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseSessionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     *
     * @OA\Schema(
     *  schema="StoreExerciseSessionRequest",
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
     *      format="double",
     *      example="5"
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
     *      property="exercises",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(
     *              property="exercise_id",
     *              format="int64",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="work_groups",
     *              format="array",
     *              example="[1, 2, 3]"
     *          ),
     *          @OA\Property(
     *              property="repetitions",
     *              format="int32",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="duration_repetitions",
     *              format="string",
     *              example="30:25"
     *          ),
     *          @OA\Property(
     *              property="break_repetitions",
     *              format="string",
     *              example="30:25"
     *          ),
     *          @OA\Property(
     *              property="series",
     *              format="int32",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="break_series",
     *              format="string",
     *              example="30:25"
     *          ),
     *      )
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
     *          property="exercise_session_place_id",
     *          format="int32",
     *          example="1"
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
            'author' => 'string',
            'title' => 'string',
            'icon' => 'nullable',
            'difficulty' => 'numeric|max:5',
            'intensity' => 'numeric|max:5',
            'duration' => 'string',
            'number_exercises' => 'numeric|max:999',
            'type_exercise_session_id' => 'integer|exists:type_exercise_sessions,id',
            'training_period_id' => 'integer|exists:training_periods,id',
            'targets'  => 'nullable|array',
            'execution' => 'required',
            'execution.date_session' => 'date',
            'execution.hour_session' => 'string|max:5',
            'execution.place_session' => 'string|max:255',
            'execution.exercise_session_place_id' => 'integer|exists:exercise_session_places,id',
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
