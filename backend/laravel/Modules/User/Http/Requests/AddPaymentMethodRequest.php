<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPaymentMethodRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     *
     * @OA\Schema(
     *      schema="AddPaymentMethodRequest",
     *      type="object",
     *      required={
     *          "payment_method_token",
     *      },
     *      @OA\Property(
     *          property="payment_method_token",
     *          format="string",
     *          example="pm_1JpzfmK6ttgcW7bgkarju4j3"
     *      )
     * )
     */
    public function rules()
    {
        return [
            'payment_method_token' => 'required|string'
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
