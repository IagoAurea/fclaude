<?php

namespace Modules\Calculator\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalculatorAnswersRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     * @OA\Schema(
     *  schema="StoreCalculatorAnswersRequest",
     *  type="object",
     *  @OA\Property(property="entity", type="string", example="injury_prevention"),
     *  @OA\Property(property="entity_id", type="int64", example="1"),
     *  @OA\Property(
     *      property="answers",
     *      type="array",
     *      example={{
     *          "item_id": 2,
     *          "option_id": 6
     *      },{
     *          "item_id": 3,
     *          "option_id": 7
     *      },{
     *          "item_id": 4,
     *          "option_id": 10
     *      },{
     *          "item_id": 5,
     *          "option_id": 14
     *      },{
     *          "item_id": 6,
     *          "option_id": 17
     *      },{
     *          "item_id": 7,
     *          "option_id": 19
     *      },{
     *          "item_id": 8,
     *          "option_id": 24
     *      },{
     *          "item_id": 9,
     *          "option_id": 26
     *      },{
     *          "item_id": 10,
     *          "option_id": 29
     *      },{
     *          "item_id": 11,
     *          "option_id": 31
     *      }},
     *      @OA\Items(
     *          @OA\Property(
     *              property="item_id",
     *              type="int64",
     *              example="1"
     *          ),
     *          @OA\Property(
     *              property="option_id",
     *              type="int64",
     *              example="2"
     *          ),
     *      )
     *  )
     * )
     */
    public function rules()
    {
        return [
            'entity' => 'string|required',
            'entity_id' => 'numeric',
            'answers'   => 'array',
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
