<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderExerciseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     *  @OA\Schema(
     *  schema="UpdateOrderExerciseRequest",
     *  type="object",
     *  required={
     *      "sessions"
     *  },
     *  @OA\Property(
     *      title="Exercises",
     *      property="exercises",
     *      description="Set exercise session exercises order",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(
     *              property="id",
     *              format="int64",
     *              example="2",
     *          ),
     *          @OA\Property(
     *              property="order",
     *              format="int64",
     *              example="1",
     *          )
     *      )
     *   )
     * )
     */
    public function rules()
    {
        return [
            'exercises' => 'array|required',
            'exercises.*.id' => 'required|integer|exists:exercise_session_exercises,id',
            'exercises.*.order' => 'required|numeric'
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
