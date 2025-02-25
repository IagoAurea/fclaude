<?php

namespace Modules\Scouting\Http\Controllers;

use Modules\Scouting\Repositories\Interfaces\ScoutingActivityRepositoryInterface;
use Modules\Scouting\Repositories\Interfaces\ScoutingRepositoryInterface;
use Modules\Scouting\Exceptions\CompetitionMatchNotFoundException;
use Modules\Scouting\Http\Requests\ScoutingActivityUpdateRequest;
use Modules\Scouting\Http\Requests\ScoutingActivityStoreRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Rest\BaseController;
use Modules\Scouting\Entities\Scouting;
use App\Traits\TranslationTrait;

class ScoutingActivityController extends BaseController
{
    use TranslationTrait;

    /**
     * Repository
     * @var $scoutingRepository
     */
    protected $scoutingRepository;

    /**
     * Repository
     * @var $scoutingActivityRepository
     */
    protected $scoutingActivityRepository;

    /**
     * Instances a new controller class
     * 
     * @param ScoutingRepositoryInterface $scoutingRepository
     * @param ScoutingActivityRepositoryInterface $scoutingActivityRepository
     */
    public function __construct(ScoutingRepositoryInterface $scoutingRepository, ScoutingActivityRepositoryInterface $scoutingActivityRepository)
    {
        $this->scoutingRepository = $scoutingRepository;
        $this->scoutingActivityRepository = $scoutingActivityRepository;
    }

    /**
     * Display a list of the scouting activities
     * for a given competition match
     * 
     * @param int $competition_match_id
     * @return Response
     */
    public function index($competition_match_id)
    {
        try {
            $scouting = $this->scoutingRepository->findOrCreateScout($competition_match_id);
            $response = $this->scoutingActivityRepository->findBy(['scouting_id' => $scouting->id, 'status' => 1]);
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError(sprintf('The competition match %s does not exist', $competition_match_id));
        }

        return $this->sendResponse($response, 'List of scouting activities');
    }

    /**
    *  @OA\Post(
    *  path="/api/v1/scouting/{competition_match_id}/activity",
    *  tags={"Scouting/Activity"},
    *  summary="Scouting update fields scouting - Actualiza un scouting",
    *  operationId="scouting-update",
    *  description="Scouting update - Actualiza un scouting",
    *  security={{"bearerAuth": {} }},
    *  @OA\Parameter( ref="#/components/parameters/_locale" ),
    *  @OA\Parameter( ref="#/components/parameters/competition_match_id" ),
    *  @OA\RequestBody(
    *      required=true,
    *      @OA\JsonContent(
    *          ref="#/components/schemas/ScoutingActivityStoreRequest"
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
     * Store a new Scouting Activity
     * for a given competition match
     * 
     * @param int $competition_match_id
     * @param ScoutingActivityStoreRequest $request
     * @return Response
     */
    public function store(ScoutingActivityStoreRequest $request, $competition_match_id)
    {
        try {
            $scouting = $this
                ->scoutingRepository
                ->findOrCreateScout($competition_match_id);

            if ($scouting->status == Scouting::STATUS_NOT_STARTED) {
                return $this
                    ->sendError(
                        $this->translator('competition_match_not_started', ['match_id' => $competition_match_id]),
                        [],
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
            }

            if ($scouting->status == Scouting::STATUS_PAUSED) {
                return $this
                    ->sendError(
                        $this->translator('competition_match_paused', ['match_id' => $competition_match_id]),
                        [],
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
            }

            if ($scouting->status == Scouting::STATUS_FINISHED) {
                return $this
                    ->sendError(
                        $this->translator('competition_match_finished', ['match_id' => $competition_match_id]),
                        [],
                        Response::HTTP_UNPROCESSABLE_ENTITY
                    );
            }

            $payload = [
                'scouting_id' => $scouting->id,
                'action_id' => $request->input('action_id'),
                'in_game_time' => $request->input('in_game_time')
            ];

            if ($request->has('player_id')) {
                $payload = array_merge($payload, ['player_id' => $request->input('player_id')]);
            }

            if ($request->has('custom_params')) {
                $payload = array_merge($payload, ['custom_params' => json_encode($request->input('custom_params'))]);
            }

            if ($request->has('rival_team_activity')) {
                $payload = array_merge($payload, ['rival_team_activity' => $request->input('rival_team_activity')]);
            }

            $activities_to_delete = $this
                ->scoutingActivityRepository
                ->findBy(['scouting_id' => $scouting->id, 'status' => 0])
                ->sortBy('created_at');

            foreach ($activities_to_delete as $activity) {
                $activity->delete();
            }

            $response = $this
                ->scoutingActivityRepository
                ->create($payload)
                ->load('action');
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError(sprintf('The competition match %s does not exist', $competition_match_id));
        }

        return $this->sendResponse($response, 'Scouting activity created');
    }

    /**
     * Update a scouting activity
     * 
     * @param int $activity
     * @param ScoutingActivityUpdateRequest $request
     * @return Response
     */
    public function update(ScoutingActivityUpdateRequest $request, $activity)
    {
        $scouting_activity = $this->scoutingActivityRepository->findOneBy(['id' => $activity]);

        if (!$scouting_activity) {
            return $this->sendError(sprintf('The activity %s does not exist', $activity));
        }

        if ($scouting_activity->scouting->status == Scouting::STATUS_PAUSED) {
            return $this->sendError($this->translator('scouting_paused'), [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($scouting_activity->scouting->status == Scouting::STATUS_FINISHED) {
            return $this->sendError($this->translator('scouting_finished'), [], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response = $scouting_activity->update($request->all());

        return $this->sendResponse($response, 'Scouting activity updated');
    }

    /**
     * Destory a scouting activity
     * 
     * @param int $activity
     * @return Response
     */
    public function destroy($activity)
    {
        $response = $this->scoutingActivityRepository->findOneBy(['id' => $activity]);

        if (!$response) {
            return $this->sendError(sprintf('The activity %s does not exist', $activity));
        }

        $response->delete();

        return $this->sendResponse([], 'Activity deleted', HttpResponse::HTTP_NO_CONTENT);
    }

    /**
     * Undo the last active scouting activity
     * for a given competition match
     * by changing its status
     * to false
     * 
     * @param int $competition_match_id
     * @return Response
     */
    public function undo($competition_match_id)
    {
        try {
            $scouting = $this->scoutingRepository->findOrCreateScout($competition_match_id);

            if ($scouting->status == Scouting::STATUS_PAUSED) {
                return $this->sendError($this->translator('scouting_paused'), [], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($scouting->status == Scouting::STATUS_FINISHED) {
                return $this->sendError($this->translator('scouting_finished'), [], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $activity = $this->scoutingActivityRepository
                ->findBy(['scouting_id' => $scouting->id, 'status' => 1])
                ->sortByDesc('created_at')
                ->first();

            if (!$activity) {
                return $this->sendError($this->translator('scouting_activities_not_undo'));
            }

            $activity->status = false;
            $activity->save();
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError(sprintf('The competition match %s does not exist', $competition_match_id));
        }
        return $this->sendResponse($activity, 'Activity removed', HttpResponse::HTTP_OK);
    }

    /**
     * Redo the last inactive scouting activity
     * for a given competition match
     * by changing its status
     * to true
     * 
     * @param int $competition_match_id
     * @return Response
     */
    public function redo($competition_match_id)
    {
        try {
            $scouting = $this->scoutingRepository->findOrCreateScout($competition_match_id);

            if ($scouting->status == Scouting::STATUS_PAUSED) {
                return $this->sendError($this->translator('scouting_paused'), [], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($scouting->status == Scouting::STATUS_FINISHED) {
                return $this->sendError($this->translator('scouting_finished'), [], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $activity = $this->scoutingActivityRepository
                ->findBy(['scouting_id' => $scouting->id, 'status' => 0])
                ->sortBy('created_at')
                ->first();

            if (!$activity) {
                return $this->sendError($this->translator('scouting_activities_not_redo'));
            }

            $activity->status = true;
            $activity->save();
        } catch (CompetitionMatchNotFoundException $exception) {
            return $this->sendError(sprintf('The competition match %s does not exist', $competition_match_id));
        }
        return $this->sendResponse($activity, 'Activity redone', HttpResponse::HTTP_OK);
    }
}
