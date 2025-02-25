<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProrationCalulatedRequest extends FormRequest
{
    /**
     *  @OA\Schema(
     *      schema="ProrationCalculatedRequest",
     *      type="object",
     *      @OA\Property(property="type", format="string", example="sport", description="Type of subscription, permitied value sport or teacher" ),
     *      @OA\Property(property="action", format="string", example="increment", description="Type of action update quatity, permitied value increment or decrement" ),
     *      @OA\Property(property="quantity", format="int64", example="5", description="Quantity license to increment or decrement"),
     * )
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|string|in:sport,teacher',
            'action' => 'required|string|in:increment,decrement',
            'licenses' => 'integer',
            'subscription' => 'integer'

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
