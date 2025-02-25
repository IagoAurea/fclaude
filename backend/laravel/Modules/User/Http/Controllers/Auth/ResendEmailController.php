<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\User\Services\UserService;
use App\Http\Controllers\Rest\BaseController;
use Modules\User\Http\Requests\ResendEmailRequest;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;


class ResendEmailController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var $userService
     */
    protected $userService;

    /**
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserService $userService
    )
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
    * @OA\Post(
    *       path="/api/v1/users/email/verify/resend",
    *       tags={"User"},
    *       summary="Resend email user register by verify - Reenvia nuevo link para verificar el correo electronico",
    *       operationId="user-email-verify-resend",
    *       description="Resend email verify user registered - Reenvia correo electronico de verificacion del usuario registrado",
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *           @OA\JsonContent(
    *               type="object",
    *               @OA\Property(property="login", type="string", example="email@example.com")
    *           )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="422",
    *           description="Return when email user has already verified",
    *           @OA\JsonContent(
    *               @OA\Property(property="success", type="string", example="false"),
    *               @OA\Property(property="message", type="string", example="Email already verified"),
    *           )
    *       )
    * )
    */
    /**
     * Resend email verify.
     * @return Response
     */
    public function __invoke(ResendEmailRequest $request)
    {
        $type_login = $this->userService->typeLogin($request->login);

        $user = $this->userRepository->findOneBy([$type_login =>  $request->login]);

        if(!$user) {
            return $this->sendError($this->translator('email_not_found'), null , Response::HTTP_NOT_FOUND);
        }

        if($user->hasVerifiedEmail()) {
            return $this->sendError(
                $this->translator('email_already_verified'), null , Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        dispatch(function () use($user) {
            $user->sendEmailVerificationNotification();
        })->afterResponse();

        $message = $this->translator('email_verification_link_sent_email') . $request->email;

        return $this->sendResponse(null, $message , Response::HTTP_OK);
    }

}
