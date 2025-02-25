<?php

namespace Modules\User\Http\Controllers;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use App\Traits\TranslationTrait;
use Modules\User\Cache\UserCache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Controllers\Rest\BaseController;
use Modules\User\Http\Requests\ListUserRequest;

class ListController extends BaseController
{
     /**
     * @var $userRepository
     */
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


     /**
     * List all users
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(ListUserRequest $request)
    {
        $users = $this->userRepository->getAllUsers();
        return response()->json($users);
    }
}