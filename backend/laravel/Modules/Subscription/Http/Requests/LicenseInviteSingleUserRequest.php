<?php

namespace Modules\Subscription\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicenseInviteSingleUserRequest extends FormRequest
{
    /**
     *  Get the validation rules that apply to the request.
     *  @return array
     * 
     *  @OA\Schema(
     *      schema="LicenseInviteSingleUserRequest",
     *      type="object",
     *      required={
     *          "email",
     *          "code",
     *      },
     *      @OA\Property(
     *          property="email",
     *          format="email",
     *          example="user@exampl.com"
     *      ),
     *      @OA\Property(
     *          property="code",
     *          format="string",
     *          example="a1b2c3d4e5-f6g7-b4-g4r3-3ff4-34d2"
     *      ),
     * )
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'code' => 'required|string|exists:licenses,code',
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
