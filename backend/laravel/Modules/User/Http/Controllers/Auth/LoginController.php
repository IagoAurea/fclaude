<?php

namespace Modules\User\Http\Controllers\Auth;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Modules\User\Services\UserService;
use Illuminate\Support\Facades\RateLimiter;
use Modules\User\Http\Requests\LoginRequest;
use App\Http\Controllers\Rest\BaseController;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;

class LoginController extends BaseController
{
    use TranslationTrait;

    /**
     * Set how many failed logins are allowed before being locked out.
     */
    protected $maxAttempts = 3;

    /**
     * Set how many seconds a lockout will last.
     */
    protected $decaySeconds = 60;

    /**
     * Set the repository for custom user functions
     */
    protected $userRepository;

    /**
     * @var $userService
     */
    protected $userService;

    public function __construct(UserService $userService, UserRepositoryInterface $userRepository)
    {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    /**
    * @OA\Post(
    *       path="/api/v1/auth/login",
    *       tags={"User"},
    *       summary="Login - Inicio de sesion",
    *       operationId="login",
    *       description="Login - Inicio de sesión<p>1. <b>email</b>: administrador@fisicalcoach.com <b>password</b>: 123456 <b>role</b>: admin</p> <p>2. <b>email</b>: api_xfs5@fisicalcoach.com  <b>password</b>: 123456 <b>role</b>: api</p>  <p>3. <b>email</b>: user_55sy6csdmp@gmail.com  <b>password</b>: 123456 <b>role</b>: user</p> <p>4. <b>email</b>: coach_busy8ybnbc@gmail.com  <b>password</b>: 123456 <b>role</b>: coach</p> <p>4. <b>email</b>: teach_mod7ra6j3q@gmail.com <b>password</b>: 123456 <b>role</b>: teaach</p> <p>5. <b>email</b>: coach_gr87li5v88@gmail.com <b>password</b>: 123456 <b>role</b>: coaach</p>",
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\RequestBody(
    *           @OA\JsonContent(
    *               type="object",
    *               @OA\Property(property="login", type="string"),
    *               @OA\Property(property="password", type="string"),
    *               @OA\Property(property="remember", type="boolean"),
    *           )
    *       ),
    *       @OA\Response(
    *           response=200,
    *           description="Return data token",
    *           @OA\JsonContent(
    *               type="object",
    *                   @OA\Property(property="token", type="string",example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOGU0MmM0ZmFkNDQ3YmVlOGI3NTdmN2M2MzY3NzA0OTg0ZWNkYmMxOWYyNDcxNTJmMjUyZmY2ZDgyMzcwNzgyNTYzYmMyZTViMGI4ZDg4ZWQiLCJpYXQiOjE2MjM4NDY4NzUuNTg0MjAyLCJuYmYiOjE2MjM4NDY4NzUuNTg0MjEsImV4cCI6MTY1NTM4Mjg3NS40OTUwOTcsInN1YiI6IjIiLCJzY29wZXMiOltdfQ.GWcoqLvU8NElqeax5Q1A6_Jem-", description="token authetication", readOnly="true"),
    *                   @OA\Property(property="expires", type="string", format="date-time", description="Date expires token timestamp", readOnly="true"),
    *           ),
    *
    *       ),
    *       @OA\Response(
    *           response="401",
    *           description="Return when user provided credentials invalid, not match records or user inactive",
    *           @OA\JsonContent(
    *               @OA\Property(property="success", type="string", example="false"),
    *               @OA\Property(property="message", type="string", example="The provided credentials do not match our records"),
    *           )
    *       ),
    *       @OA\Response(
    *           response="429",
    *           description="Return when user too many attemps with invalid credentials",
    *           @OA\JsonContent(
    *               @OA\Property(property="success", type="string", example="false"),
    *               @OA\Property(property="message", type="string", example="Too Many Attempts"),
    *           )
    *       )
    * )
    */
     /**
     * Login session user.
     * @return object
     */
    public function login(LoginRequest $request)
    {
        if ($this->checkTooManyFailedAttempts()) {
            return $this->sendError($this->translator('throttle', ['seconds' => $this->decaySeconds]), NULL, Response::HTTP_TOO_MANY_REQUESTS);
        }

        $type_login = $this->userService->typeLogin($request->login);

        $user_active = $this->userService->verifyIfUseActive($type_login, $request->login);

        if (!$user_active) {
            return $this->sendError($this->translator('user_not_active'), null, Response::HTTP_NOT_FOUND);
        }

        try {
            $data = $request->only('password');

            $data[$type_login] = $request->login;
            $data['active'] = true;

            if (Auth::attempt($data)) {
                $dataToken = $this->userService->createToken(Auth::user(), $request->remember);

                // Check if the request has an invitation token
                if ($request->club_invite_token) {
                    $this->userService->handleInvitationUserLogin($request);
                }

                return $this->sendResponse($dataToken, $this->translator('successful_login'), Response::HTTP_OK);
            }

            RateLimiter::hit($this->throttleKey(), $this->decaySeconds);

            return $this->sendError($this->translator('provided_credentials_not_match'), NULL , Response::HTTP_UNAUTHORIZED);

        } catch (Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }


    /**
    * @OA\Post(
    *       path="/api/v1/auth/logout",
    *       tags={"User"},
    *       summary="Logout - Cierre de sesion",
    *       operationId="logout",
    *       description="Logout session user and invalidate token - Cierre de sesión de usuario e invalidacion de token",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess",
    *
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Logout session user.
     * @return object
     */
    public function logout(Request $request)
    {
        try {
            $logout = $request->user()->token()->revoke();

            return $this->sendResponse($logout, $this->translator('successful_logout'));
        } catch(Exception $exception) {
            return $this->sendError('Error', $exception->getMessage());
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower(request('login')) . '|' . request()->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return boolean|null
     */
    public function checkTooManyFailedAttempts()
    {
        if ( RateLimiter::tooManyAttempts($this->throttleKey(), $this->maxAttempts)) {
            return true;
        }
    }


}
