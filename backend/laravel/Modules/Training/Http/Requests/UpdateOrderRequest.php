<?php

namespace Modules\Training\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     *  @OA\Schema(
     *  schema="UpdateOrderRequest",
     *  type="object",
     *  required={
     *      "sessions"
     *  },
     *  @OA\Property(
     *      title="Sessions",
     *      property="sessions",
     *      description="Set session exercise order",
     *      type="array",
     *      @OA\Items(
     *          @OA\Property(property="id", type="integer", format="int64", example="2"),
     *          @OA\Property(property="order", type="integer", format="int64", example="1")
     *      )
     *   )
     *  ),
     * )
     */
    public function rules()
    {
        return [
            'sessions' => 'required|array',
            'sessions.*.order' => 'required|integer',
            'sessions.*.id' => 'required|integer|exists:exercise_sessions,id',
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
