<?php

namespace Modules\Injury\Services;

use Exception;
use App\Traits\ResponseTrait;
use App\Traits\TranslationTrait;
use Modules\Player\Entities\Player;
use Modules\Club\Entities\ClubType;
use Modules\Test\Services\TestService;
use Modules\Injury\Entities\InjuryRfdCriteria;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\PhaseRepositoryInterface;
use Modules\Player\Repositories\Interfaces\PlayerRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\InjuryRfdRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\PhaseDetailRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestApplicationRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\CurrentSituationRepositoryInterface;
use Modules\Injury\Repositories\Interfaces\ReinstatementCriteriaRepositoryInterface;

class RfdService
{
    use ResponseTrait, TranslationTrait;

    /**
     * @var $phaseDetailRepository
     */
    protected $phaseDetailRepository;

    /**
     * @var $phaseRepository
     */
    protected $phaseRepository;

    /**
     * @var $situationRepository
     */
    protected $situationRepository;

    /**
     * @var $rfdRepository
     */
    protected $rfdRepository;

    /**
     * @var $criteriaRepository
     */
    protected $criteriaRepository;

    /**
     * @var $testRepository
     */
    protected $testRepository;

    /**
     * @var $testApplicationRepository
     */
    protected $testApplicationRepository;

    /**
     * @var $playerRepository
     */
    protected $playerRepository;

    /**
     * @var $injuryRepository
     */
    protected $injuryRepository;

    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    /**
     * @var $testService
     */
    protected $testService;

    public function __construct(
        PhaseDetailRepositoryInterface $phaseDetailRepository,
        PhaseRepositoryInterface  $phaseRepository,
        CurrentSituationRepositoryInterface $situationRepository,
        InjuryRfdRepositoryInterface $rfdRepository,
        ReinstatementCriteriaRepositoryInterface  $criteriaRepository,
        TestRepositoryInterface $testRepository,
        PlayerRepositoryInterface $playerRepository,
        InjuryRepositoryInterface $injuryRepository,
        TestApplicationRepositoryInterface $testApplicationRepository,
        ClubRepositoryInterface $clubRepository,
        TestService $testService
    ) {
        $this->phaseDetailRepository = $phaseDetailRepository;
        $this->phaseRepository = $phaseRepository;
        $this->situationRepository = $situationRepository;
        $this->rfdRepository = $rfdRepository;
        $this->criteriaRepository = $criteriaRepository;
        $this->testRepository = $testRepository;
        $this->playerRepository = $playerRepository;
        $this->injuryRepository = $injuryRepository;
        $this->testApplicationRepository = $testApplicationRepository;
        $this->clubRepository = $clubRepository;
        $this->testService = $testService;
    }

    const FILTERS = [
        'type-injury'        => 'injury_type_spec_translations.name',
        'severity-injury'    => 'injury_severity_translations.name',
        'location-injury'    => 'injury_location_translations.name'
    ];

     /**
     * Retrieve all injuries rfd create by players
     */
    public function allInjuriesRfdByUser($user_id)
    {
        $clubs = $this->clubRepository->findUserClubs($user_id, ClubType::CLUB_TYPE_SPORT, [], ['teams.players']);

        $clubs->makeHidden(['users']);

        $total_injuries_rfd = $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                return $team->players->map(function ($player) {
                    $player->injuries_rfd = $this->rfdRepository->allInjuriesRfdByPlayer($player->id);

                    return $player->injuries_rfd->count();
                })->sum();
            })->sum();
        })->sum();

        return [
            'clubs' => $clubs,
            'total_injuries_rfd' => $total_injuries_rfd ?? 0
        ];
    }

    /**
     * Response string
     * @param string $filter
     * @param string $value
     * @return string
     */
    public function getFilterList($filter, $value)
    {

        $field = self::FILTERS[$filter];
        $operator = "LIKE";
        $value = '%' . $value . '%';

        return  [$field, $operator, $value];
    }

    /**
     * Response success
     * @param int $rfd_id
     * @return array
     */
    public function createPhases($rfd_id)
    {
        try {
            $rfd = $this->rfdRepository->find($rfd_id);

            if (!$rfd) {
                $dataResponse['success'] = false;
                $dataResponse['message'] = "The rfd not found";
                return $dataResponse;
            }

            $dataResponse = [
                "success" => true,
                "data" => "",
            ];

            $phases = $this->phaseRepository->findAll();
            $creates = [];

            $situation = $this->situationRepository->findOneBy(["code" => "cant_passed"]);
            $situation_psychological = $this->situationRepository->findOneBy(["code" => "cant_return"]);

            foreach ($phases as $phase) {

                // $situation_id = $phase->code == "psychological" ? $situation->id : $situation_psychological->id;
                if ($phase->code == "psychological") {
                    $situation_id = $situation_psychological->id;
                } else {
                    $situation_id = $situation->id;
                }

                $phaseDetailCreate = [];
                $phaseDetailCreate['injury_rfd_id'] = $rfd_id;
                $phaseDetailCreate['phase_id'] = $phase->id;
                $phaseDetailCreate['test_code'] = $phase->code;
                $phaseDetailCreate['sport_id'] = $this->generateSportId($phase->code, $rfd_id);
                $phaseDetailCreate['current_situation_id'] = $situation_id;
                $phaseDetailCreate['percentage_complete'] = 0;

                $phaseDetail = $this->phaseDetailRepository->create($phaseDetailCreate);

                array_push($creates,  $phase);
            }

            $dataResponse['success'] = true;
            $dataResponse['message'] = "Phases Create to rfd " . $rfd_id;
            $dataResponse['data'] = $creates;

            return    $dataResponse;
        } catch (Exception $exception) {

            $dataResponse['success'] = false;
            $dataResponse['message'] = $exception->getMessage();
            return $dataResponse;
        }
    }

    /**
     * Response success
     * @param int $rfd_id
     * @return array
     */
    public function createCriteria($rfd_id)
    {
        try {
            $rfd = $this->rfdRepository->find($rfd_id);

            if (!$rfd) {
                $dataResponse['success'] = false;
                $dataResponse['message'] = "The rfd not found";
                return $dataResponse;
            }

            $dataResponse = [
                "success" => true,
                "data" => "",
            ];


            $criteria = $this->criteriaRepository->findAll();
            $creates = [];

            foreach ($criteria as $criterion) {

                $criteria = new InjuryRfdCriteria;
                $criteria->injury_rfd_id = $rfd_id;
                $criteria->reinstatement_criteria_id = $criterion->id;
                $criteria->value = false;
                $criteria->save();

                array_push($creates, $criterion);
            }

            $dataResponse['success'] = true;
            $dataResponse['message'] = "Criteria Create to rfd " . $rfd_id;
            $dataResponse['data'] = $creates;

            return $dataResponse;
        } catch (Exception $exception) {

            $dataResponse['success'] = false;
            $dataResponse['message'] = $exception->getMessage();
            return $dataResponse;
        }
    }

    /**
     * Response success
     * @param int $phase_detail_id
     * @return array
     */
    public function evaluatePhase($phase_detail_id, $request)
    {
        try {
            $dataResponse = [
                "success" => true,
                "message" => "",
                "data" => "",
            ];

            $request['applicable_id'] = $phase_detail_id;
            $request['entity_name'] = "rfd";
            $request['test_id'] = $this->getTestId($phase_detail_id);

            $phaseDetail = $this->phaseDetailRepository->find($phase_detail_id);

            if (!$phaseDetail) {
                $dataResponse['success'] = false;
                $dataResponse['message'] = "The Phase Detail not found";
                return $dataResponse;
            }

            $validatePrePhase = $this->validatePrePhase($phaseDetail->id, $phaseDetail->injury_rfd_id);

            if (!$validatePrePhase) {

                $dataResponse['success'] = false;
                $dataResponse['message'] = "The previous phase has not been evaluated";
                return $dataResponse;
            }

            $test = $this->testRepository->find($request['test_id']);

            if (!$test) {
                $dataResponse['success'] = false;
                $dataResponse['message'] = "The Test not found";
                return $dataResponse;
            }


            $before_application = $this->testApplicationRepository->findOneBy([
                'applicable_type' => 'Modules\Injury\Entities\PhaseDetail',
                'applicable_id' => $phase_detail_id
            ]);

            $answers = $this->testService->validateAnswers($request['answers'], $request['test_id']);

            if (!$answers['success']) {
                $dataResponse['success'] = false;
                $dataResponse['message'] = $answers['message'];
                return $dataResponse;
            }

            $request['answers'] = $answers['data'];

            $request['applicant_id'] = $phaseDetail->injury_rfd->injury->entity_id;
            $request['applicant_type'] = Player::class;

            if (!$before_application) {
                $testApplication = $this->testApplicationRepository->createTestApplication($request);
            } else {
                $testApplication = $this->testApplicationRepository->updateTestApplication($before_application->id, $request);
            }

            $result = $this->testService->calculateTestResult($testApplication->id);

            if (!$result['success']) {
                $dataResponse['success'] = false;
                $dataResponse['message'] = $result['message'];
                return $dataResponse;
            }

            $result = $result['data']['value'];


            if ($test->type_valoration_code == "points") {
                $result = ($result * 100) / intval($test->value);
            }

            $phaseDetail->percentage_complete =  $result;
            $phaseDetail->current_situation_id = $this->getCurrentSituation($phaseDetail->id, $phaseDetail->percentage_complete);
            $phaseDetail->phase_passed = $this->getPhasePassed($phaseDetail->id, $phaseDetail->percentage_complete);
            $phaseDetail->update();

            $rfd = $phaseDetail->injury_rfd;

            $rfd_advance = $this->calculateInjuryrfdAdvance($rfd->id);

            if (!$rfd_advance['success']) {
                $dataResponse['success'] = false;
                $dataResponse['message'] = $result['message'];
                return $dataResponse;
            }

            $dataResponse['success'] = true;
            $dataResponse['message'] = "Phase Evaluate";
            $dataResponse['data'] = $phaseDetail;

            return $dataResponse;
        } catch (Exception $exception) {
            $dataResponse['success'] = false;
            $dataResponse['message'] = $exception->getMessage();
            return $dataResponse;
        }
    }

    /**
     * Response success
     * @param int $rfd_id
     * @return array
     */
    public function calculateInjuryrfdAdvance($rfd_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        $rfd = $this->rfdRepository->find($rfd_id);

        if (!$rfd) {
            $dataResponse['success'] = false;
            $dataResponse['message'] = "The rfd not found";
            return $dataResponse;
        }

        $percentage = 0;

        $phases_detail = $rfd->phase_details;

        foreach ($phases_detail as $phase_detail) {

            $phase_percentage = $phase_detail->phase->percentage_value;

            $phase_avance = ($phase_detail->percentage_complete *  $phase_percentage) / 100;

            $percentage = $percentage + $phase_avance;
        }

        $rfd->percentage_complete = $percentage;
        $rfd->update();

        $dataResponse['success'] = true;
        $dataResponse['message'] = "rfd Update ";
        $dataResponse['data'] = $rfd;

        return $dataResponse;
    }

    /**
     * Response success
     * @param int $phase_detail_id
     * @return array
     */
    public function getTestId($phase_detail_id)
    {
        $phaseDetail = $this->phaseDetailRepository->find($phase_detail_id);

        $phase = $phaseDetail->phase;

        if ($phase->code == 'retraining') {
            $test = $this->testRepository->findOneBy([
                "code" => $phase->test_code, "sport_id" => $phaseDetail->sport_id
            ]);

            if (!$test) {
                throw new Exception('There is no tests associated to this sport id');
            }
        } else {
            $test = $this->testRepository->findOneBy(["code" => $phase->test_code]);
        }

        return $test->id;
    }

    /**
     * Response success
     * @param int $player_id
     * @return array
     */
    public function rfdAbstractByPlayer($player_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];


        $abstract = [];

        $player = $this->playerRepository->find($player_id);

        if (!$player) {

            $dataResponse['success'] = false;
            $dataResponse['message'] = "The Player not found";
            return $dataResponse;
        }


        $count_total = $player->injuries->count();

        $count_total_severity = $this->injuryRepository->groupInjuryBySeverity($player->id);

        $count_total_type = $this->injuryRepository->groupInjuryByType($player->id);

        $count_total_location = $this->injuryRepository->groupInjuryByLocation($player->id);

        $total_days_absence = $this->injuryRepository->totalAbsenceByInjury($player->id);

        $abstract['player_id'] = $player->id;
        $abstract['player_full_name'] = $player->full_name;
        $abstract['grand_total'] = $count_total;
        $abstract['total_severity'] = $count_total_severity;
        $abstract['total_type'] = $count_total_type;
        $abstract['total_location'] = $count_total_location;
        $abstract['total_days_absence'] = $total_days_absence->total;


        $dataResponse['success'] = true;
        $dataResponse['message'] = "Abstract By Player ";
        $dataResponse['data'] = $abstract;

        return $dataResponse;
    }

    /**
     * Response success
     * @param int $player_id
     * @return array
     */
    public function rfdHistoricByPlayer($player_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        $player = $this->playerRepository->find($player_id);

        if (!$player) {

            $dataResponse['success'] = false;
            $dataResponse['message'] = "The Player not found";
            return $dataResponse;
        }

        $rfds = $player->injuries->map->rfd;

        $data = $rfds->map(function ($rfd) {
            return [
                'id' => $rfd->id,
                'injury_id' => $rfd->injury->id,
                'annotations' => $rfd->annotations,
                'percentage_complete' => $rfd->percentage_complete,
                'closed' => $rfd->closed,
                'phase_details' => $rfd->phase_details,
            ];
        });

        $dataResponse['success'] = true;
        $dataResponse['message'] = "Historic of RFDs by player";
        $dataResponse['data'] = $data;

        return $dataResponse;
    }

    /**
     * Response success
     * @param array $criterias
     * @param int $rfd_id
     * @return array
     */
    public function updatedCriterias($criterias, $rfd_id)
    {
        try {
            $rfd = $this->rfdRepository->find($rfd_id);

            foreach ($criterias as $criterion) {
                $rfd->criterias()->updateExistingPivot($criterion['id'], array(
                    'value' => $criterion['value']
                ));
            }

            return $criterias;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * Response string
     * @param int $rfd_id
     * @return string
     */
    public function closedRfd($rfd_id)
    {
        $dataResponse = [
            "success" => true,
            "message" => "",
            "data" => "",
        ];

        $phases_passed = false;
        $criterias_passed = false;

        $rfd = $this->rfdRepository->find($rfd_id);

        if (!$rfd) {
            $dataResponse['success'] = false;
            $dataResponse['message'] = "The rfd not found";
            return $dataResponse;
        }

        $phases_detail = $rfd->phase_details;

        foreach ($phases_detail as $phase_detail) {
            if ($phase_detail->phase_passed) {
                $phases_passed = true;
            } else {

                $dataResponse['success'] = false;
                $dataResponse['message'] = $this->translator(
                    sprintf('phase_%s_not_passed', $phase_detail->phase->code));
                return $dataResponse;
            }
        }


        $criterias = $rfd->criterias;

        foreach ($criterias as $criterion) {

            if ($criterion->pivot->value) {
                $criterias_passed = true;
            } else {

                $dataResponse['success'] = false;
                $dataResponse['message'] = "Criterion " . $criterion->code . " not marked";
                return $dataResponse;
            }
        }

        if ($phases_passed && $criterias_passed) {
            $rfd->closed = true;
            $rfd->update();

            $result['phases_passed'] = $phases_passed;
            $result['criterias_passed'] = $criterias_passed;
            $result['closed'] =  $rfd->closed;

            $dataResponse['success'] = true;
            $dataResponse['message'] = "Rfd Closed ";
            $dataResponse['data'] = $result;
        } else {

            $dataResponse['success'] = false;
            $dataResponse['message'] = "Error Closed Rfd";
        }

        return $dataResponse;
    }

    /**
     * Response success
     * @param int $phase_detail_id
     * @return array
     */
    private function getCurrentSituation($phase_detail_id, $percentage)
    {
        $phaseDetail = $this->phaseDetailRepository->find($phase_detail_id);

        $phase = $phaseDetail->phase;
        $type = 2;
        if ($phase->code == 'psychological') {
            $type  = 1;
        }

        $currentSituation = $this->situationRepository->findOneBy([
            ['type', '=', $type],
            ['min_percentage', '<=', $percentage],
            ['max_percentage', '>=', $percentage],
        ]);

        return $currentSituation->id;
    }

    private function getPhasePassed($phase_detail_id, $percentage)
    {
        $phaseDetail = $this->phaseDetailRepository->find($phase_detail_id);

        $phase = $phaseDetail->phase;
        $injury = $phaseDetail->injury_rfd->injury;

        if ($percentage >= $phase->min_percentage_pass) {

            if ($phase->code == "recovery") {
                $injury->medically_discharged_at = date("Y-m-d");
                $injury->update();
            } elseif ($phase->code == "retraining") {
                $injury->sportly_discharged_at = date("Y-m-d");
                $injury->update();
            } elseif ($phase->code == "reincor_competition") {
                $injury->competitively_discharged_at = date("Y-m-d");
                $injury->update();
            }

            return true;
        }

        return false;
    }

    /**
     * Response success
     * @param int $phase_code
     * @param int $rfd_id
     * @return int (or null)
     */
    private function generateSportId($phase_code, $rfd_id)
    {
        if ($phase_code != 'retraining') { return null; }

        $rfd = $this->rfdRepository->find($rfd_id);

        return $rfd->injury->entity->team->sport_id;
    }

    /**
     * Response success
     * @param int $phase_id
     * @return boolean 
     */
    private function validatePrePhase($phase_detail_id, $injury_rfd_id)
    {
        $pre_phase_id = $phase_detail_id - 1;
        $pre_phase_detail = $this->phaseDetailRepository->find($pre_phase_id);

        if (!$pre_phase_detail) {
            return true;
        }

        if ($pre_phase_detail->injury_rfd_id != $injury_rfd_id) {
            return true;
        }

        if ($pre_phase_detail->phase->code == 'psychological') {
            return true;
        }

        return $pre_phase_detail->phase_passed;
    }
}
