<?php

namespace Modules\Training\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Training\Repositories\Interfaces\WorkGroupRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class WorkGroupService
{
    /**
     * @var $workGroupRepository
     */
    protected $workGroupRepository;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $alumnRepository
     */
    protected $alumnRepository;

    /**
     * @var $classroomRepository
     */
    protected $classroomRepository;

    /**
     * @var $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;

     /**
     * Creates a new service instance
     */
    public function __construct(
        WorkGroupRepositoryInterface $workGroupRepository,
        PlayerRepositoryInterface $playerRepository,
        AlumnRepositoryInterface $alumnRepository,
        ClassroomRepositoryInterface $classroomRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository
    )
    {
        $this->workGroupRepository = $workGroupRepository;
        $this->playerRepository = $playerRepository;
        $this->alumnRepository = $alumnRepository;
        $this->classroomRepository = $classroomRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
    }

     /**
     * List alumns of work group
     */
    public function listAlumns($exercise_session)
    {
        $workGroups = $this->workGroupRepository->findBy(['exercise_session_id' => $exercise_session->id]);

        $alumnsId = [];

        foreach ($workGroups as $workGroup) {
            $alumnsWorkGroup = $workGroup->alumns;

            foreach ($alumnsWorkGroup as $alumnWorkGroup) {
                array_push($alumnsId, $alumnWorkGroup['id']);
            }
        }

        $classroom = $this->classroomRepository->findOneBy(['id' => $exercise_session->entity_id]);

        $classroomActiveAcademicYearId = $classroom->activeAcademicYears->first()->pivot->id;

        $classroomYear = $this->classroomAcademicYearRepository->findOneBy([
            'id' => $classroomActiveAcademicYearId
        ]);

        $alumns = [];

        foreach ($classroomYear->alumns as $alumn) {
            if (!in_array($alumn->id, $alumnsId)) {
                array_push($alumns, $alumn);
            }
        }

        return $alumns;
    }

    /**
     * List work groups with alumns
     */
    public function listWorkGroupsAlumns($exercise_session)
    {
        $workGroups = $this->workGroupRepository->findBy(['exercise_session_id' => $exercise_session->id]);

        foreach ($workGroups as $workGroup) {
            foreach ($workGroup->alumns as $alumn) {
                $alumn->image;
            }
        }

        return $workGroups;
    }

    /**
     * List work groups with players
     */
    public function listWorkGroupsPlayers($exercise_session)
    {
        $workGroups = $this->workGroupRepository->findBy(['exercise_session_id' => $exercise_session->id]);

        foreach ($workGroups as $workGroup) {
            foreach ($workGroup->players as $player) {
                $player->image;
            }
        }

        return $workGroups;
    }

    /**
     * List players of work group
     */
    public function listPlayers($exercise_session)
    {
        $workGroups = $this->workGroupRepository->findBy(['exercise_session_id' => $exercise_session->id]);

        $playersId = [];

        foreach ($workGroups as $workGroup) {
            $playersWorkGroup = $workGroup->players;
        
            foreach ($playersWorkGroup as $playerWorkGroup) {
               array_push($playersId, $playerWorkGroup['id']);
            }
        }

        return $this->playerRepository->findPlayersByTeamAndExclude(
            [ 'team_id' => $exercise_session->entity_id ],
            $playersId,
            ['image']
        );
    }

    /**
     * Update work group
     */
    public function updateWorkGroup($request, $workGroup)
    {
        $valueWork = $this->validateEntity($request);
        $players = $request->players;
        $alumns = $request->alumns;

        try {
            DB::beginTransaction();

            $this->workGroupRepository->update($valueWork, $workGroup);

            isset($players) ?
                $this->saveWorkGroupPlayer($workGroup, $players, true) :
                $this->saveWorkGroupAlumn($workGroup, $alumns, true);

            DB::commit();

            return $workGroup;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Create work group with players or alumns
     */
    public function createWorkGroup($request)
    {
        $valueWork = $this->validateEntity($request);
        $players = $request->players;
        $alumns = $request->alumns;

        try {
            DB::beginTransaction();

            $workGroup = $this->workGroupRepository->create($valueWork);

            isset($players) ?
                $this->saveWorkGroupPlayer($workGroup, $players) :
                $this->saveWorkGroupAlumn($workGroup, $alumns);

            DB::commit();

            return $workGroup;
        } catch (Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    /**
     * Save relation alumns with work group
     */
    private function saveWorkGroupPlayer($workGroup, $players, $deleteAll = false)
    {
        if ($deleteAll) {
            $workGroup->players()->detach();
        }

        foreach ($players as $player_id) {
            $player = $this->playerRepository->findOneBy(['id' => $player_id]);

            $workGroup->players()->save($player);
        }
    }

    /**
     * Save relation alumns with work group
     */
    private function saveWorkGroupAlumn($workGroup, $alumns, $deleteAll = false)
    {
        if ($deleteAll) {
            $workGroup->alumns()->detach();
        }

        foreach ($alumns as $alumn_id) {
            $alumn = $this->alumnRepository->findOneBy(['id' => $alumn_id]);

            $workGroup->alumns()->save($alumn);
        }
    }

    /**
     * Validate entity case Player or Alumn
     */
    private function validateEntity($request)
    {
        if (isset($request->players) && count($request->players)) {
            $valueWork = $request->except('players');
        } elseif (isset($request->alumns) && count($request->alumns)) {
            $valueWork = $request->except('alumns');
        } else {
            abort(response()->error("Player or Alumns not found", Response::HTTP_NOT_FOUND));
        }

        return $valueWork;
    }

}
