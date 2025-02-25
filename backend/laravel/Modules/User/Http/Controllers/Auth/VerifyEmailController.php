<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Rest\BaseController;
use App\Traits\TranslationTrait;

class VerifyEmailController extends BaseController
{
    use TranslationTrait;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Valid a request verified email.
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $user = $this->userRepository->find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return $this->sendError($this->translator('email_already_verified'), NULL, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        $user->active = true;

        $user->save();

        $payload = [
            'user_id' => $user->id,
            'tax' => $user->tax,
            'is_company' => $user->is_company,
            'country_id' => $user->country_id,
            'province_id' => $user->province_id,
        ];

        return $this->sendResponse($payload, $this->translator('email_verified'), Response::HTTP_OK);
    }
}
