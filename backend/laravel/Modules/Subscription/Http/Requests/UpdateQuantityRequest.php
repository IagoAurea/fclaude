<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuantityRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *      schema="UpdateQuantityRequest",
     *      type="object",
     *      @OA\Property(property="type", format="string", example="sport", description="Type of subscription, permitied value sport or teacher" ),
     *      @OA\Property(property="action", format="string", example="increment", description="Type of action update quatity, permitied value increment or decrement" ),
     *      @OA\Property(property="quantity", format="int64", example="5", description="Quantity license to increment or decrement"),
     *      @OA\Property(property="codes", format="array", example="['code1','code2']", description="Codes licenses to remove"),
     * )
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action' => 'required|string|in:increment,decrement',
            'quantity' => 'required|integer',
            'type' => 'required|string|in:sport,teacher',
            'codes' => 'array|required_if:action,decrement',
            'codes.*' => 'required|string|exists:licenses,code',
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
