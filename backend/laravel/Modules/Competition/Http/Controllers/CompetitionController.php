<?php

namespace Modules\Competition\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResourceTrait;
use App\Traits\TranslationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Activity\Events\ActivityEvent;
use App\Http\Controllers\Rest\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Modules\Generality\Services\ResourceService;
use Modules\Competition\Services\CompetitionService;
use Modules\Competition\Http\Requests\CompetitionRequest;
use Modules\Competition\Http\Requests\VerifyMatchRequest;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingResultRepositoryInterface;

class CompetitionController extends BaseController
{
    use ResourceTrait, TranslationTrait;

    /**
     * Competition Repository
     * @var $competitionRepository
     */
    protected $competitionRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Repository
     * @var $scoutingResultRepository
     */
    protected $scoutingResultRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var $competitionService
     */
    protected $competitionService;

    /**
     * CompetitionController constructor.
     * @param CompetitionRepositoryInterface $competitionRepository
     * @param ResourceRepositoryInterface $resourceRepository
     * @param ScoutingResultRepositoryInterface $scoutingResultRepository
     * @param ResourceService $resourceService
     * @param CompetitionService $competitionService
     */
    public function __construct(
        CompetitionRepositoryInterface $competitionRepository,
        ResourceRepositoryInterface $resourceRepository,
        ScoutingResultRepositoryInterface $scoutingResultRepository,
        ResourceService $resourceService,
        CompetitionService $competitionService
    ) {
        $this->competitionRepository = $competitionRepository;
        $this->resourceRepository = $resourceRepository;
        $this->scoutingResultRepository = $scoutingResultRepository;
        $this->resourceService = $resourceService;
        $this->competitionService = $competitionService;
    }

    /**
     * Get All Competitions
     * @return JsonResponse
     */
    public function index()
    {
        return $this->sendResponse($this->competitionRepository->findAll(), 'List all competitions');
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/competitions/{competition_id}",
     *  tags={"Competitions"},
     *  summary="Competition Show - Detalle de Competicion",
     *  operationId="competition-show",
     *  description="Get Competition By Id - Detalle de competicion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/competition_id" ),
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
    /**
     * Get Competition by ID
     * @param $id
     * @return JsonResponse
     */
    public function getById($id)
    {
        $competition = $this->competitionRepository->find($id);

        if (!$competition) {
            return $this->sendError('Competition Not Found!', 'NOT_FOUND', Response::HTTP_NOT_FOUND);
        }

        $permission = Gate::inspect('read-competition', $competition->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $competition->typeCompetition;
        $competition->matches;

        foreach ($competition->matches as $match) {
            $scouting = $match->scouting;

            if (!$scouting) {
                $match->score = null;
                continue;
            }

            $results = $this->scoutingResultRepository->findOneBy([
                'scouting_id' => $scouting->id
            ]);

            $match->score = $results->data->score ?? null;

            $match->makeHidden('scouting');
        }

        $competition->typeCompetition->makeHidden('translations');

        return $this->sendResponse(
            $competition,
            'Competition Show'
        );
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/competitions/team/{team_id}",
     *  tags={"Competitions"},
     *  summary="Competition Team Index - Listado de Competiciones por equipo",
     *  operationId="competition-index",
     *  description="Get all Competitions of Team - Lista de competiciones por equipo",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
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
    /**
     * Get all competitions associated with team id
     * @param $team_id
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllByTeam($team_id, Request $request)
    {
        $filter = $request->search ?? null;

        return $this->sendResponse(
            $this->competitionRepository->findAllByTeamId($team_id, $filter),
            "Competitions by user authenticated"
        );
    }

    /**
     *  @OA\Post(
     *  path="/api/v1/competitions",
     *  tags={"Competitions"},
     *  summary="Competition store - Crear una competicion",
     *  operationId="competitions-store",
     *  description="Store a new competition - Crea una nueva competicion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreCompetitionRequest")
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
    /**
     * Endpoint to create a Competition
     * @param CompetitionRequest $request
     * @return JsonResponse
     */
    public function store(CompetitionRequest $request)
    {
        $permission = Gate::inspect('store-competition', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $competitionData = $request->except('image');

        try {
            if ($request->image) {
                $dataResource = $this->uploadResource('/competitions', $request->image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $competitionData['image_id'] = $resource->id;
                }
            }

            $competition = $this->competitionRepository->create($competitionData);

            event(
                new ActivityEvent(
                    Auth::user(),
                    $competition->team->club,
                    'competition_created',
                    $competition->team
                )
            );

            return $this->sendResponse($competition, $this->translator('competition_create_message'), Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('An error has occurred', $exception->getMessage());
        }
    }

    /**
     *  @OA\Post(
     *  path="/api/v1/competitions/{competition_id}",
     *  tags={"Competitions"},
     *  summary="Competition update - Actualiza una competicion",
     *  operationId="competitions-store",
     *  description="Update a competition - Actualiza una competicion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(ref="#/components/schemas/StoreCompetitionRequest")
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
    /**
     *
     * @param CompetitionRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(CompetitionRequest $request, $id)
    {
        $permission = Gate::inspect('update-competition', $request->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $competition = $this->competitionRepository->find($id);

        if (!$competition) {
            return $this->sendError('Competition not found!', 'NOT_FOUND', Response::HTTP_NOT_FOUND);
        }

        $competitionData = $request->except('image');

        try {
            if ($request->image) {
                $dataResource = $this->uploadResource('/competitions', $request->image);
                $resource = $this->resourceRepository->create($dataResource);
                if ($resource) {
                    $competitionData['image_id'] = $resource->id;
                }
            }

            $competitionData = $this->competitionRepository->update($competitionData, ["id" => $id]);

            if ($request->image && $competition->image_id) {
                $this->resourceService->deleteResourceData($competition->image_id);
            }

            event(
                new ActivityEvent(
                    Auth::user(),
                    $competition->team->club,
                    'competition_updated',
                    $competition->team
                )
            );

            return $this->sendResponse($competitionData, $this->translator('competition_update_message'));
        } catch (Exception $exception) {
            return $this->sendError('An error has occurred', $exception->getMessage());
        }
    }

    /**
     *  @OA\Get(
     *  path="/api/v1/competitions/{competition_id}/team/{team_id}/verify-matches",
     *  tags={"Competitions"},
     *  summary="Competition Matches verify of team by date - Verificacion de partidos de competiciones de equipo por fecha",
     *  operationId="competition-matches-verify",
     *  description="Verify matches competition of team by date - Verifica si hay partidos en competiciones en la fecha proporcionada",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/competition_id" ),
     *  @OA\Parameter( ref="#/components/parameters/team_id" ),
     *  @OA\Parameter( ref="#/components/parameters/match_date" ),
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
    /**
     * Endpoint allowing to verify if the equipment has match during the sport time on the date provided
     * @param VerifyMatchRequest
     * @param $team_id
     * @param $competition_id
     * @return JsonResponse
     */
    public function getVerifyMatchOfTeamByDate(VerifyMatchRequest $request, $competition_id, $team_id)
    {
        $hasMatches = $this->competitionService->verifyMatchesCompetitionByDate($competition_id, $request->date_start);

        return $this->sendResponse(['hasMatches' => $hasMatches], "Verify matches of team by date");
    }

    /**
     *  @OA\Delete(
     *  path="/api/v1/competitions/{competition_id}",
     *  tags={"Competitions"},
     *  summary="Competition Delete - Eliminar de Competicion",
     *  operationId="competition-delete",
     *  description="Delete a Competition By Id - Eliminar de competicion",
     *  security={{"bearerAuth": {} }},
     *  @OA\Parameter( ref="#/components/parameters/_locale" ),
     *  @OA\Parameter( ref="#/components/parameters/competition_id" ),
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
    /**
     * Get Competition by ID
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $competition = $this->competitionRepository->find($id);

        if (!$competition) {
            return $this->sendError('Competition Not Found!', 'NOT_FOUND', Response::HTTP_NOT_FOUND);
        }

        $permission = Gate::inspect('delete-competition', $competition->team_id);

        if (!$permission->allowed()) {
            return $this->sendError($permission->message(), null, Response::HTTP_FORBIDDEN);
        }

        $competition->forceDelete();

        return $this->sendResponse(
            null,
            'Competition deleted succesfully'
        );
    }
}
