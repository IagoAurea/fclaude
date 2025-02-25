<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     *
     *  @OA\Schema(
     *      schema="CreateSubscriptionRequest",
     *      type="object",
     *      required={
     *          "package_price_id",
     *          "interval",
     *          "quantity",
     *          "payment_method_token",
     *          "user_id",
     *          "type"
     *      },
     *      @OA\Property(
     *          property="package_price_id",
     *          format="int64",
     *          example="1"
     *      ),
     *      @OA\Property(
     *          property="interval",
     *          format="string",
     *          example="month"
     *      ),
     *      @OA\Property(
     *          property="quantity",
     *          format="int64",
     *          example="5"
     *      ),
     *      @OA\Property(
     *          property="payment_method_token",
     *          format="string",
     *          example="pm_1JpzfmK6ttgcW7bgkarju4j3"
     *      ),
     *      @OA\Property(
     *          property="user_id",
     *          format="int64",
     *          example="1"
     *      ),
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
            'package_price_id' => 'required|integer|exists:packages_price,id',
            'interval' => 'required|in:month,year',
            'quantity' => 'required|integer',
            'payment_method_token' => 'required|string',
            'user_id' => 'required|integer|exists:users,id',
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
