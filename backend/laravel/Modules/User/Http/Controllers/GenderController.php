<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;

class GenderController extends BaseController
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
    * @OA\Get(
    *       path="/api/v1/users/gender",
    *       tags={"User"},
    *       summary="Get list Gender - Lista de genero",
    *       operationId="list-gender",
    *       description="Return data list gender - Retorna listado de genero de usuario",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Display a listing of the gender.
     * @return Response
     */
    public function index()
    {
        return $this->sendResponse($this->userRepository->getGenderTypes(), 'List Genders');
    }

    /**
    * @OA\Get(
    *       path="/api/v1/users/gender-identity",
    *       tags={"User"},
    *       summary="Get list Gender Identity- Lista de identidad de genero",
    *       operationId="list-gender-identity",
    *       description="Return data list gender identity - Retorna listado de identidad de genero",
    *       security={{"bearerAuth": {} }},
    *       @OA\Parameter( ref="#/components/parameters/_locale" ),
    *       @OA\Response(
    *           response=200,
    *           ref="#/components/responses/reponseSuccess"
    *       ),
    *       @OA\Response(
    *           response="401",
    *           ref="#/components/responses/notAuthenticated"
    *       )
    * )
    */
    /**
     * Display a listing of the gender identity.
     * @return Response
     */
    public function indexGenderIdentity()
    {
        return $this->sendResponse($this->userRepository->getGenderIdentityTypes(), 'List Genders Identity');
    }


}
