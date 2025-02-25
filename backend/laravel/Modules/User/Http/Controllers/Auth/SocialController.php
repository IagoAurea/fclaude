<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Modules\User\Services\UserService;
use Laravel\Socialite\Facades\Socialite;
use Modules\User\Http\Requests\SocialRequest;
use App\Http\Controllers\Rest\BaseController;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Exception;

class SocialController extends BaseController
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
     * @var string $provider
     */
    protected $provider = 'google';

    public function __construct(UserRepositoryInterface $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    /**
     * Login with account Google.
     * @return Response
     */
    public function login(SocialRequest $request)
    {
        try {
            $socialUser = Socialite::driver($this->provider)->scopes([
                'profile', 'email'
            ]);
    
            if(!$socialUser) {
                return $this->sendError($this->translator('provider_missing'), NULL , Response::HTTP_UNPROCESSABLE_ENTITY);
            }
    
            $socialUserDetails = $socialUser->userFromToken($request->auth_token);
    
            if(!$socialUserDetails) {
                return $this->sendError($this->translator('invalid_credentials'), NULL , Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // Find user by both parameters such as google_id or email sent
            $existentUser = $this->userRepository->findOrWhere(
                ['provider_google_id' => $socialUserDetails->id],
                [
                    ['email' => $socialUserDetails->getEmail()],
                ]
            );

            if ($existentUser) {
                // Save the provider google_id
                $existentUser->provider_google_id = $socialUserDetails->id;
                $existentUser->save();

                // Create the login token
                $dataToken = $this->userService->createToken($existentUser);

                // In case it has no active subscriptions or is not currently active
                // a boolean value must be sent in order to redirect a subscription view
                $mustSubscribe = 
                    !$existentUser->subscriptionActive || !$existentUser->active 
                        ? true 
                        : false;

                // Retrieve the data
                $data = [
                    'token' => $dataToken['token'],
                    'expires' => $dataToken['expires'],
                    'must_subscribe' => $mustSubscribe,
                ];

                return $this->sendResponse($data, $this->translator('successful_login'));
            }
        
            // If not found, send the google information on the response
            $data = [
                'google_information' => $socialUserDetails,
            ];
    
            return $this->sendError($this->translator('user_not_found'), $data, Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return $this->sendError($exception->getMessage(), NULL, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
