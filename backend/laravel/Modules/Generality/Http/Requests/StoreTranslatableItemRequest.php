<?php

namespace Modules\Generality\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTranslatableItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     * 
     * @OA\Schema(
     *  schema="StoreTranslatableItemRequest",
     *  required={
     *      "en",
     *      "es",
     *      "code"
     *  },
     *  @OA\Property(
     *      title="Name in Spanish",
     *      property="es",
     *      description="Spanish typed name",
     *      format="string",
     *      example="Titulo de ejemplo",
     *  ),
     *  @OA\Property(
     *      title="Name in English",
     *      property="en",
     *      description="English typed name",
     *      format="string",
     *      example="Example title",
     *  ),
     *  @OA\Property(
     *      title="Code",
     *      property="code",
     *      description="code",
     *      format="string",
     *      example="example_code",
     *  ),
     * )
     * 
     * @OA\Schema(
     *  schema="SingleTranslatableItemResponse",
     *  type="object",
     *  description="New education level item stored in database",
     *  @OA\Property(property="success", type="boolean", example="true"),
     *  @OA\Property(property="message", type="string", example="string"),
     *  @OA\Property(
     *      property="data",
     *      type="object",
     *      @OA\Property(
     *          property="id",
     *          format="int64",
     *          example="1",
     *      ),
     *      @OA\Property(
     *          property="code",
     *          format="string",
     *      ),
     *      @OA\Property(
     *          property="name",
     *          format="string",
     *      ),
     *      @OA\Property(
     *          property="translations",
     *          type="array",
     *          @OA\Items(
     *              @OA\Property(
     *                  property="locale",
     *                  format="string",
     *                  example="string",
     *              ),
     *              @OA\Property(
     *                  property="name",
     *                  format="string",
     *                  example="string",
     *              ),
     *              @OA\Property(
     *                  property="id",
     *                  format="int64",
     *                  example="1",
     *              ),
     *          )
     *      )
     *  ),
     * )
     * 
     * @OA\Schema(
     *  schema="DeleteTranslatableItemResponse",
     *  @OA\Property(
     *      property="success",
     *      type="boolean",
     *      example="true",
     *  ),
     *  @OA\Property(
     *      property="message",
     *      format="string",
     *      example="string",
     *  ),
     *  @OA\Property(
     *      property="data",
     *      type="boolean",
     *      example="true",
     *  ),
     * )
     */
    public function rules()
    {
        return [
            //
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
