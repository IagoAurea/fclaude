<?php

namespace Modules\Exercise\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="StoreTeamExerciseRequest",
     *  type="object",
     *  required={
     *      "title",
     *      "distribution_exercise_id",
     *  },
     *  @OA\Property(property="title", format="string", example="string"),
     *  @OA\Property(property="description", format="string", example="string"),
     *  @OA\Property(property="dimensions", format="string", example="string"),
     *  @OA\Property(property="duration", format="string", example="10:10"),
     *  @OA\Property(property="repetitions", format="int64", example="1"),
     *  @OA\Property(property="duration_repetitions", format="string", example="10:10"),
     *  @OA\Property(property="break_repetitions", format="string", example="10:10"),
     *  @OA\Property(property="series", format="int64", example="1"),
     *  @OA\Property(property="break_series", format="string", example="10:10"),
     *  @OA\Property(property="difficulty", format="int64", example="1"),
     *  @OA\Property(property="intensity", format="int64", example="1"),
     *  @OA\Property(property="distribution_exercise_id", format="int64", example="1"),
     *  @OA\Property(
     *      property="content_exercise_ids",
     *      format="array",
     *      example="[1, 2, 3]"
     *  ),
     * )
     * 
     * @OA\Schema(
     *  schema="StoreClassroomExerciseRequest",
     *  type="object",
     *  required={
     *      "title",
     *      "distribution_exercise_id",
     *  },
     *  @OA\Property(property="title", format="string", example="string"),
     *  @OA\Property(property="description", format="string", example="string"),
     *  @OA\Property(property="dimensions", format="string", example="string"),
     *  @OA\Property(property="duration", format="string", example="10:10"),
     *  @OA\Property(property="repetitions", format="int64", example="1"),
     *  @OA\Property(property="duration_repetitions", format="string", example="10:10"),
     *  @OA\Property(property="break_repetitions", format="string", example="10:10"),
     *  @OA\Property(property="series", format="int64", example="1"),
     *  @OA\Property(property="break_series", format="string", example="10:10"),
     *  @OA\Property(property="difficulty", format="int64", example="1"),
     *  @OA\Property(property="intensity", format="int64", example="1"),
     *  @OA\Property(property="distribution_exercise_id", format="int64", example="1"),
     *  @OA\Property(property="exercise_education_level_id", format="int64", example="1"),
     *  @OA\Property(property="sport_id", format="int64", example="1"),
     *  @OA\Property(
     *      property="content_block_ids",
     *      format="array",
     *      example="[1, 2, 3]"
     *  ),
     *  @OA\Property(
     *      property="target_ids",
     *      format="array",
     *      example="[1, 2, 3]"
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3',
            'description' => 'nullable|string|min:3',
            'dimensions' => 'nullable|string|min:3',
            'duration' => 'nullable|string|max:5|min:5|regex:/^\d{2}:\d{2}$/',
            'repetitions' => 'nullable|integer|min:0',
            'duration_repetitions' => 'nullable|string|max:5|min:5|regex:/^\d{2}:\d{2}$/',
            'break_repetitions' => 'nullable|string|max:5|min:5|regex:/^\d{2}:\d{2}$/',
            'series' => 'nullable|integer|min:0',
            'break_series' => 'nullable|string|max:5|min:5|regex:/^\d{2}:\d{2}$/',
            'difficulty' => 'nullable|integer|min:0',
            'intensity' => 'nullable|integer|min:0',
            'exercise_education_level_id' => 'sometimes|integer|exists:exercise_education_levels,id',
            'distribution_exercise_id' => 'nullable|integer|exists:distribution_exercises,id',
            'content_exercise_ids' => 'sometimes|array',
            'content_exercise_ids.*' => 'integer|exists:contents_exercise,id',
            'content_block_ids' => 'sometimes|array',
            'content_block_ids.*' => 'integer|exists:exercise_content_blocks,id',
            'target_ids' => 'sometimes|array',
            'target_ids.*' => 'integer|exists:target_sessions,id',
            'sport_id' => 'integer|exists:sports,id',
            'team_id' => 'required|integer|exists:teams,id'
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
