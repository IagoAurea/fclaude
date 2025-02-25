<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelSubscriptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     *  @OA\Schema(
     *      schema="CancelSubscriptionRequest",
     *      type="object",
     *      required={
     *          "type"
     *      },
     *      @OA\Property(
     *          property="type",
     *          format="string",
     *          example="sport",
     *          description="Send sport or teacher by type of subscription"
     *      ),
     * )
     */
    public function rules()
    {
        return [
            'type' => 'required|string|in:sport,teacher'
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
