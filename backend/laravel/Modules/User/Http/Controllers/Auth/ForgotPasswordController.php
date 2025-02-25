<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Rest\BaseController;
use Modules\User\Http\Requests\ForgotPasswordRequest;
use Modules\User\Http\Requests\ResetPasswordRequest;
use App\Traits\TranslationTrait;

class ForgotPasswordController extends BaseController
{
    use TranslationTrait;

    /**
    * @OA\Post(
    *       path="/api/v1/auth/forgot-password",
    *       tags={"User"},
    *       summary="Forgot password - Solicitud reseteo de contraseña",
    *       operationId="password",
    *       description="Forgot password - Solicitud por parte de usuario de reseteo de contraseña",
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *           @OA\JsonContent(
    *               type="object",
    *               @OA\Property(property="email", type="string"),
    *           )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           description="Return message send email",
    *           @OA\JsonContent(
    *               type="object",
    * 				@OA\Property(property="success", type="string", example="false"),
    * 				@OA\Property(property="message", type="string", example="We have emailed your password reset link!."),
    *           ),
    *
    *       ),
    *       @OA\Response(
    *           response="422",
    *           description="Return when user data invalid",
    *           @OA\JsonContent(
    *               @OA\Property(property="success", type="string", example="false"),
    *               @OA\Property(property="message", type="string", example="We can't find a user with that email address.")
    *           )
    *       ),
    * 		@OA\Response(
    *           response="429",
    *           description="Return when user too many attemps forgot password",
    *           @OA\JsonContent(
    *               @OA\Property(property="success", type="string", example="false"),
    *               @OA\Property(property="message", type="string", example="Please wait before retrying."),
    *           )
    *       )
    * )
    */
    /**
     * Forgot password user and send email link reset.
     * @return object
     */
    public function forgot(ForgotPasswordRequest $request)
    {
        $credentials = $request->only('email');

        $status = Password::sendResetLink($credentials);

        switch ($status) {
            case Password::RESET_LINK_SENT:
                return $this->sendResponse(NULL, trans($status), Response::HTTP_OK);

            case Password::RESET_THROTTLED:
                return $this->sendResponse(NULL, trans($status), Response::HTTP_TOO_MANY_REQUESTS);

            case Password::INVALID_USER:
                return $this->sendError(trans($status), NULL, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
    * @OA\Post(
    *     path="/api/v1/auth/reset-password",
    *     tags={"User"},
    *     summary="Reset password - Resetea contraseña",
    *     description="Reset password - Reseteo de contraseña de usuario",
    *     @OA\Parameter( ref="#/components/parameters/_locale" ),
    *     @OA\RequestBody(
    *        @OA\JsonContent(
    *           type="object",
    *           @OA\Property(property="email", type="string", example="email@example.com", description="email user request"),
    *           @OA\Property(property="token", type="string", example="Ar4eRD$das17s%", description="token send email user request"),
    *           @OA\Property(property="password", type="string", description="The password must contain lower case, upper case, number and special character, minimun 8 characters"),
    *           @OA\Property(property="password_confirmation", type="string", type="string", description="The confirmation password"),
    *        )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Return message success.",
    *         @OA\JsonContent(
    *               type="object",
    *               @OA\Property(property="success", type="string", example="true"),
    *               @OA\Property(property="message", type="string", example="Your password has been reset!"),
    *         ),
    *     ),
    *     @OA\Response(
    *         response="404",
    *         description="Return when reset token is invalid",
    *          @OA\JsonContent(
    *               type="object",
    *               @OA\Property(property="success", type="string", example="false"),
    *               @OA\Property(property="message", type="string", example="This password reset token is invalid"),
    *         ),
    *     ),
    *     @OA\Response(
    *         response="422",
    *         description="Return when user data invalid",
    *         @OA\JsonContent(
    *               type="object",
    *               @OA\Property(property="success", type="string", example="false"),
    *               @OA\Property(property="message", type="string", example="The given data was invalid."),
    *               @OA\Property(property="errors", type="objetc", example="{}"),
    *         ),
    *     )
    * )
    */
    /**
     * Forgot password user and send email link reset.
     * @return object
     */
    public function reset(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => $password
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        switch ($status) {
            case Password::PASSWORD_RESET:
                return $this->sendResponse(NULL, trans($status), Response::HTTP_OK);

            case Password::INVALID_TOKEN:
                return $this->sendError(trans($status), NULL, Response::HTTP_NOT_FOUND);

            case Password::INVALID_USER:
                return $this->sendError(trans($status), NULL, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
