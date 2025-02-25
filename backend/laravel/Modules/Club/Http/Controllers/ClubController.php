<?php

namespace Modules\Club\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ResourceTrait;
use Modules\Club\Entities\Club;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Club\Services\ClubService;
use App\Http\Controllers\Rest\BaseController;
use Modules\Club\Http\Requests\StoreClubRequest;
use Modules\Club\Http\Requests\UpdateClubRequest;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

class ClubController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * @var object
     */
    protected $clubRepository;

    /**
     * @var $clubService
     */
    protected $clubService;

    /**
     * Instances a new controller class
     */
    public function __construct(
        ClubRepositoryInterface $clubRepository,
        ClubService $clubService
    ) {
        $this->clubRepository = $clubRepository;
        $this->clubService = $clubService;
    }

    /**
     * Display all the clubs related to the user doing the request.
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/clubs",
     *  tags={"Club"},
     *  summary="Club Index - Listado de Clubes",
     *  operationId="club-index",
     *  description="Shows a list of clubs owned by the requesting user
     *  - Muestra el listado de clubes pertenecientes al usuario que hace la consulta",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function index()
    {
        $clubs = $this->clubService->index();

        return $this->sendResponse($clubs, $this->translator('club_controller_list_response_message'));
    }

    /**
     * Stores a new club into the database.
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/clubs",
     *  tags={"Club"},
     *  summary="Store Club - Crear Club",
     *  operationId="club-store",
     *  description="Stores a new club - Crea un nuevo club",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreClubRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function store(StoreClubRequest $request)
    {
        $user = Auth::user();
    
        $permission = Gate::inspect('store-club', $user);
    
        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $clubData = $request->only('name', 'image');

            $addressData = $request->only(
                'street', 'postal_code', 'city', 'country_id', 'province_id', 'mobile_phone', 'phone'
            );

            $club = $this->clubService->store($user, $clubData, $addressData);

            $message = $this->translator('club_controller_store_response_message');

            return $this->sendResponse($club, $message, Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError(
                'Error by storing club', $exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Show the specified club.
     *
     * @param Int $id
     * @return Response
     *
     * @OA\Get(
     *  path="/api/v1/clubs/{club_id}",
     *  tags={"Club"},
     *  summary="Show Club - Mostrar Club",
     *  operationId="club-show",
     *  description="Shows club's information - Muestra informacion de club",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function show($id)
    {
        $permission = Gate::inspect('read-club', $id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $club = $this->clubService->show($id);

            return $this->sendResponse($club, $this->translator('club_controller_show_response_message'));
        } catch (Exception $exception) {
            return $this->sendError('Error by retrieving club', $exception->getMessage());
        }
    }

    /**
     * Updates all the club data sent on storage.
     *
     * @param Request $request
     * @param Int $id
     * @return Response
     *
     * @OA\Post(
     *  path="/api/v1/clubs/{club_id}",
     *  tags={"Club"},
     *  summary="Updates club information - Actualiza informacion de club",
     *  operationId="club-update",
     *  description="Updates an existent club from database - Actualiza un club existente de la base de datos",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/UpdateClubRequest")
     *      )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function update(UpdateClubRequest $request, $id)
    {
        $permission = Gate::inspect('update-club', $id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }
        
        $clubData = $request->only('name', 'image');

        $addressData = $request->only(
            'street', 'postal_code', 'city', 'country_id', 'province_id', 'mobile_phone', 'phone'
        );

        try {
            $club = $this->clubService->update($id, $clubData, $addressData);

            return $this->sendResponse($club, $this->translator('club_controller_update_response_message'));
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            return $this->sendError($exception->getMessage(), 'Error by updating club');
        }
    }

    /**
     * Makes a logical club deletion from database.
     *
     * @param Int $id
     * @return Response
     * @OA\Delete(
     *  path="/api/v1/clubs/{club_id}",
     *  tags={"Club"},
     *  summary="Delete Club - Eliminar Club",
     *  operationId="club-delete",
     *  description="Deletes an existent club - Elimina un club existente",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter(
     *      ref="#/components/parameters/club_id"
     *  ),
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     *  @OA\Response(
     *      response="404",
     *      ref="#/components/responses/resourceNotFound"
     *  )
     * )
    */
    public function destroy($id)
    {
        $permission = Gate::inspect('delete-club', $id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        try {
            $this->clubService->delete($id);

            return $this->sendResponse(null,
                $this->translator('club_controller_delete_response_message'), Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting club', $exception->getMessage());
        }
    }

    /**
     * Retrieves all the club related activities stored in the databases.
     * 
     * @param Int $id
     * @return Response Listing of the activities related
     * 
     * @OA\Get(
     *  path="/api/v1/clubs/{club_id}/activities",
     *  tags={"Club"},
     *  summary="Show Club Activities - Mostrar Actividades de Club",
     *  operationId="club-list-activities",
     *  description="Shows club's activities information - Muestra informacion de actividades de club",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\Response(
     *      response=200,
     *      ref="#/components/responses/reponseSuccess"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      ref="#/components/responses/unprocessableEntity"
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  )
     * )
     */
    public function activities($id)
    {
        try {
            $activities = $this->clubRepository->getClubActivities($id);
            return $this->sendResponse($activities, 'Club activity');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting club', $exception->getMessage());
        }
    }

    /**
     * Retrieves a list of all club teams matches.
     * @return Response
     * 
     * @OA\Get(
     *  path="/api/v1/clubs/{club_id}/teams-matches",
     *  tags={"Club"},
     *  summary="Club teams matches list",
     *  operationId="list-team",
     *  description="Retrieves a list of all club's teams related matches regardless of competition",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/club_id" ),
     *  @OA\Response(
     *      response=200,
     *      description="Match list response",
     *      @OA\JsonContent(
     *          ref="#/components/schemas/ClubTeamsMatchesListResponse"
     *      )
     *  ),
     *  @OA\Response(
     *      response="401",
     *      ref="#/components/responses/notAuthenticated"
     *  ),
     * )
     */
    public function teamsMatches(Club $club)
    {
        try {
            $matches = $this->clubService->getAllTeamsMatches($club);
            return $this->sendResponse($matches, 'Club teams matches');
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting club', $exception->getMessage());
        }
    }
}
