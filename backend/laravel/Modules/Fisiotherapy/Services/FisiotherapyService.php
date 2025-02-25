<?php

namespace Modules\Fisiotherapy\Services;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Traits\TranslationTrait;
use Illuminate\Support\Facades\Auth;
use Modules\Player\Entities\Player;
use Modules\Club\Entities\ClubType;
use Modules\Test\Services\TestService;
use Modules\Fisiotherapy\Entities\File;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Fisiotherapy\Repositories\Interfaces\FileRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestApplicationRepositoryInterface;

class FisiotherapyService
{
    use ResponseTrait, TranslationTrait;

    /**
     * @var object $fileRepository
     */
    protected $fileRepository;

    /**
     * @var object $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $testApplicationRepository
     */
    protected $testApplicationRepository;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * @var $testService
     */
    protected $testService;

    /**
     * Create a new service instance
     */
    public function __construct(
        FileRepositoryInterface $fileRepository,
        PlayerRepositoryInterface $playerRepository,
        TestRepositoryInterface $testRepository,
        TestApplicationRepositoryInterface $testApplicationRepository,
        ClubRepositoryInterface $clubRepository,
        TestService $testService
    ) {
        $this->fileRepository = $fileRepository;
        $this->playerRepository = $playerRepository;
        $this->testRepository = $testRepository;
        $this->testApplicationRepository = $testApplicationRepository;
        $this->clubRepository = $clubRepository;
        $this->testService = $testService;
    }

    /**
     * Retrieve all files fisiotherapy create by players
     */
    public function allTestsByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, ClubType::CLUB_TYPE_SPORT, [], ['teams.players']);

        $clubs->makeHidden(['users']);

        $total_files_fisiotherapy = $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                return $team->players->map(function ($player) {
                    $player->files_fisiotherapy = $this->fileRepository->findBy([
                        'player_id' => $player->id
                    ]);

                    return $player->files_fisiotherapy->count();
                })->sum();
            })->sum();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_files_fisiotherapy' => $total_files_fisiotherapy ?? 0
        ];
    }

    /**
     * Retrieves a list of all players
     *
     * @return array
     */
    public function listPlayers($queryParams, $teamId)
    {
        try {
            return $this->playerRepository->lastFileFisiotherapy($teamId, $queryParams);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves a test application
     *
     * @return array
     */
    public function testApplication($request)
    {
        $before_application = $this->testApplicationRepository->findOneBy([
            'applicable_type' => File::class,
            'applicable_id' => $request['applicable_id']
        ]);

        $application =  $request->except(['answers', 'entity_name']);

        $answers = $this->testService->validateAnswers($request['answers'], $request['test_id']);

        if (!$answers['success']) {
            abort(response()->error($answers['message'], Response::HTTP_NOT_FOUND));
        }

        $application['answers'] = $answers['data'];

        $application['applicant_id'] = $request->player_id;
        $application['applicant_type'] = Player::class;
        $application['entity_name'] = "fisiotherapy";
        $application['user_id'] = Auth::id();

        $testApplication = !$before_application ?
            $this->testApplicationRepository->createTestApplication($application) :
            $testApplication = $this->testApplicationRepository->updateTestApplication(
                $before_application->id,
                $application
            );


        $result = $this->testService->calculateTestResult($testApplication->id);

        $test = $this->testRepository->find($request['test_id']);

        $percentage = 0;

        if ($test->type_valoration_code == "points") {
            $percentage = ($result['data']['value'] * 100) / intval($test->value);
        }

        $result['data']['percentage'] = $percentage;

        return $result;
    }

    /**
     * Retrieves detail test application
     *
     * @return array
     */
    public function getDetailTestApplication($file, $player, $team)
    {
        $playerData = $this->playerRepository->findOneBy(
            ['id' => $player],
            ['full_name', 'height', 'weight', 'image_id', 'date_birth', 'gender_id', 'team_id']
        );

        if ($team != $playerData->team_id) {
            abort(Response::HTTP_FORBIDDEN, $this->translator('user_forbidden'));
        }

        $application = $this->testApplicationRepository->findOneBy([
            'applicable_id' => $file,
            'applicable_type' => File::class
        ]);

        if (!$application) {
            $test['result'] = null;
            $test['player'] = $playerData;

            return $test;
        }

        $test = $this->testRepository->findTestAll($application->test_id, app()->getLocale())->toArray();

        $test['result'] = $application->result;
        $test['player'] = $playerData;

        $application_data = $this->testApplicationRepository->findTestApplicationAll($application->id, false);

        if ($application_data) {
            $test['previous_application'] = $application_data;
        }

        return $test;
    }
}
