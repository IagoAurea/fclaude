<?php

namespace Modules\Package\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowDetailPackageRequest extends FormRequest
{
    /**
     *  @OA\Schema(
     *   schema="ShowDetailPackageRequest",
     *   @OA\Property( property="licenses", description="Quantity license to search", format="int64", example="5" ),
     *   @OA\Property( property="type", description="Type package sport or teacher", format="string", example="sport" ),
     *   @OA\Property( property="subpackage", description="Type subpackage bronze, silver or gold", format="string", example="silver"),
     *   @OA\Property( property="period", description="Period type month or year", format="string", example="month"),
     *  )
     *
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'licenses' => 'required|integer',
            'type' => 'required|exists:packages,code',
            'subpackage' => 'required|in:bronze,silver,gold',
            'period' => 'required|in:month,year'
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
