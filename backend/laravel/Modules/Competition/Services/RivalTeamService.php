<?php

namespace Modules\Competition\Services;

use Exception;
use App\Traits\ResourceTrait;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Activity\Events\ActivityEvent;
use Modules\Generality\Services\ResourceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionMatchRepositoryInterface;
use Modules\Competition\Repositories\Interfaces\CompetitionRivalTeamRepositoryInterface;

class RivalTeamService
{
    use ResourceTrait, TranslationTrait;

    /**
     * @var object $rivalTeamRepository
     */
    protected $rivalTeamRepository;
    
    /**
     * @var object $competitionMatchRepository
     */
    protected $competitionMatchRepository;

    /**
     * @var object $resourceService
     */
    protected $resourceService;

    /**
     * @var object $resourceRepository
     */
    protected $resourceRepository;

    /**
     * Creates a new service instance
     */
    public function __construct(
        CompetitionRivalTeamRepositoryInterface $rivalTeamRepository,
        CompetitionMatchRepositoryInterface $competitionMatchRepository,
        ResourceRepositoryInterface $resourceRepository,
        ResourceService $resourceService
    ) {
        $this->rivalTeamRepository = $rivalTeamRepository;
        $this->competitionMatchRepository = $competitionMatchRepository;
        $this->resourceRepository = $resourceRepository;
        $this->resourceService = $resourceService;
    }

    /**
     * Store information rival team
     * @param array $rivalTeamData
     * 
     * @return object 
     */
    public function store($rivalTeamData, $user = null)
    {
        try {
            $data = [
                'competition_id' => $rivalTeamData['competition_id'],
                'rival_team' => $rivalTeamData['name']
            ];

            if (isset($rivalTeamData['image'])) {
                $dataResource = $this->uploadResource('/rival-teams', $rivalTeamData['image']);
                $resource = $this->resourceRepository->create($dataResource);
                $data['image_id'] = $resource->id;
            }

            $rivalTeam = $this->rivalTeamRepository->create($data);

            if ($user) {
                event(
                    new ActivityEvent(
                        $user,
                        $rivalTeam->competition->team->club,
                        'competition_rival_team_created',
                        $rivalTeam->competition->team,
                    )
                );
            }

            return $rivalTeam;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates information about an specific rival team
     * 
     * @return bool|object
     */
    public function update($id, $rivalTeamData)
    {
        try {
            $rivalTeam = $this->rivalTeamRepository->findOneBy(['id' => $id]);

            if (!$rivalTeam) {
                throw new ModelNotFoundException;
            }

            if (isset($rivalTeamData['image'])) {
                $dataResource = $this->uploadResource('/clubs', $rivalTeamData['image']);
                $resource = $this->resourceRepository->create($dataResource);
                $rivalTeamData['image_id'] = $resource->id;
                $deletableImageId = $rivalTeam->image_id;
            }

            // Do the update
            $updated = $this->rivalTeamRepository->update($rivalTeamData, $rivalTeam);

            // After updating, delete the old image if exists
            if (isset($deletableImageId)) {
                $this->resourceService->deleteResourceData($deletableImageId);
            }

            event(
                new ActivityEvent(
                    Auth::user(),
                    $rivalTeam,
                    'competition_rival_team_created'
                )
            );

            return $updated;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Delete information about an specific rival team
     * 
     * @return bool|object
     */
    public function delete($id)
    {
        $rivalTeam = $this->rivalTeamRepository->findOneBy(['id' => $id]);

        if (!$rivalTeam) {
            throw new ModelNotFoundException;
        }

        $competitionsMatch = $this->competitionMatchRepository->findMatchRivalTeamByDateUnderCurrent($id);

        if(count($competitionsMatch) > 0) {
            abort(response()->error($this->translator('team_not_can_delete'), Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        try {
            $deleted = $this->rivalTeamRepository->delete($id);

            event(
                new ActivityEvent(
                    Auth::user(),
                    $rivalTeam,
                    'competition_rival_team_created'
                )
            );

            return $deleted;
        } catch (Exception $exception) {
            abort(response()->error($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY));
        }
    }

    /**
     * @param array $competition_id
     * 
     * @return object 
     */
    public function removeRivalTeams($competition_id)
    {
        return $this->rivalTeamRepository->bulkDelete(['competition_id' => $competition_id]);
    }
}
