<?php

namespace Modules\Player\Http\Controllers;

use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Rest\BaseController;
use Exception;

// External Repositories
use Modules\Player\Repositories\Interfaces\PlayerTrajectoryRepositoryInterface;

// External services
use Modules\Player\Services\PlayerTrajectoryService;

class PlayerTrajectoryController extends BaseController
{
    use ResponseTrait;

    /**
     * @var $playerTrajectoryService
     */
    protected $playerTrajectoryService;

    /**
     * @var $playerTrajectoryRepository
     */
    protected $playerTrajectoryRepository;

    /**
     * Creates a new controller instance
     */
    public function __construct(
        PlayerTrajectoryService $playerTrajectoryService,
        PlayerTrajectoryRepositoryInterface $playerTrajectoryRepository
    ) {
        $this->playerTrajectoryService = $playerTrajectoryService;
        $this->playerTrajectoryRepository = $playerTrajectoryRepository;
    }

    /**
     * Display a listing of the player's trajectory.
     * @return Response
     */
    public function index($playerId)
    {   
        $trajectories = $this->playerTrajectoryRepository->findBy([
            'player_id' => $playerId
        ]);

        foreach ($trajectories as $trajectory) {
            $trajectory->image;
            $trajectory->clubArrivalType;
        }

        return $this->sendResponse($trajectories, 'Player Trajectory List');
    }

    /**
     * Stores a new trajectory.
     * @param Request $request
     * @param Int $id
     * @return Response
     */
    public function store(Request $request, $id)
    {
        try {
            $trajectory_data = $request->all();

            $trajectory_data['player_id'] = $id;

            $trajectory = $this->playerTrajectoryService->insertPlayerTrajectory($trajectory_data);
    
            return $this->sendResponse($trajectory, 'Player Trajectory Stored', Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return $this->sendError('Error by creating a new trajectory', $exception->getMessage());
        }
    }

    /**
     * Show the specified trajectory.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $trajectory = $this->playerTrajectoryRepository->findOneBy([
            'id' => $id
        ]);

        if (!$trajectory) {
            return $this->sendError('Trajectory not found', NULL, Response::HTTP_NOT_FOUND);
        }

        $trajectory->image;
        $trajectory->clubArrivalType;

        return $this->sendResponse($trajectory, 'Player Trajectory Information');
    }

    /**
     * Update the specified trajectory.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $playerId, $trajectoryId)
    {
        try {
            $trajectory_data = $request->all();
    
            $trajectory_data['player_id'] = $playerId;

            $trajectory = $this->playerTrajectoryService->updatePlayerTrajectory($trajectory_data, $trajectoryId);

            return $this->sendResponse($trajectory, 'Player Trajectory updated');
        } catch (Exception $exception) {
            return $this->sendError('Error by updating contract', $exception->getMessage());
        }
    }

    /**
     * Remove the specified trajectory from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->playerTrajectoryRepository->delete($id);
            return $this->sendResponse(NULL, 'Player trajectory deleted', Response::HTTP_ACCEPTED);
        } catch (Exception $exception) {
            return $this->sendError('Error by deleting player', $exception->getMessage());
        }
    }
}
