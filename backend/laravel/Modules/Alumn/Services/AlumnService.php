<?php

namespace Modules\Alumn\Services;

use Exception;
use App\Helpers\Helper;

// Repositories
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\AlumnSportRepositoryInterface;
use Modules\Health\Repositories\Interfaces\HealthRepositoryInterface;
use Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Generality\Repositories\Interfaces\ResourceRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

// Traits
use App\Traits\ResourceTrait;
use App\Traits\ResponseTrait;

// External Services
use Modules\Generality\Services\ResourceService;
use Modules\Injury\Services\InjuryService;
use Modules\Address\Services\AddressService;
use Modules\Family\Services\FamilyService;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Classroom\Services\ClassroomAcademicYearService;
use Modules\Tutorship\Services\Interfaces\TutorshipServiceInterface;
use Modules\Alumn\Repositories\Interfaces\AlumnSubjectRepositoryInterface;
use Modules\Evaluation\Services\Interfaces\EvaluationResultServiceInterface;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\EvaluationResultRepositoryInterface;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlItemRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\ClassroomAcademicYearAlumnRepositoryInterface;

class AlumnService
{
    use ResponseTrait, ResourceTrait;

    /**
     * @var $alumnRepository
     */
    protected $alumnRepository;

    /**
     * @var object $alumnSportRepository
     */
    protected $alumnSportRepository;

    /**
     * @var object $alumnSubjectRepository
     */
    protected $alumnSubjectRepository;

    /**
     * @var $userRepository
     */
    protected $userRepository;

    /**
     * @var $playerHealthRepository
     */
    protected $playerHealthRepository;

    /**
     * @var $resourceRepository
     */
    protected $resourceRepository;

    /**
     * @var object
     */
    protected $classroomAcademicYearRepository;

    /**
     * @var object
     */
    protected $classroomAcademicYearAlumnRepository;

    /**
     * @var object
     */
    protected $evaluationResultRepository;

    /**
     * @var object
     */
    protected $dailyControlRepository;

    /**
     * @var object
     */
    protected $dailyControlItemRepository;

    /**
     * @var $resourceService
     */
    protected $resourceService;

    /**
     * @var object
     */
    protected $addressService;

    /**
     * @var object
     */
    protected $familyService;
    
    /**
     * @var object
     */
    protected $injuryService;
    
    /**
     * @var object
     */
    protected $classroomAcademicYearService;
    
    /**
     * @var object
     */
    protected $evaluationResultService;
    
    /**
     * @var object
     */
    protected $tutorshipService;

    /**
     * @var $helper
     */
    protected $helper;

    public function __construct(
        ClassroomAcademicYearService $classroomAcademicYearService,
        AlumnRepositoryInterface $alumnRepository,
        AlumnSportRepositoryInterface $alumnSportRepository,
        AlumnSubjectRepositoryInterface $alumnSubjectRepository,
        UserRepositoryInterface $userRepository,
        HealthRepositoryInterface $playerHealthRepository,
        ResourceRepositoryInterface $resourceRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository,
        ClassroomAcademicYearAlumnRepositoryInterface $classroomAcademicYearAlumnRepository,
        EvaluationResultServiceInterface $evaluationResultService,
        EvaluationResultRepositoryInterface $evaluationResultRepository,
        TutorshipServiceInterface $tutorshipService,
        DailyControlRepositoryInterface $dailyControlRepository,
        DailyControlItemRepositoryInterface $dailyControlItemRepository,
        ResourceService $resourceService,
        AddressService $addressService,
        FamilyService $familyService,
        InjuryService $injuryService,
        Helper $helper
    ) {
        $this->classroomAcademicYearService = $classroomAcademicYearService;
        $this->alumnRepository = $alumnRepository;
        $this->alumnSportRepository = $alumnSportRepository;
        $this->alumnSubjectRepository = $alumnSubjectRepository;
        $this->userRepository = $userRepository;
        $this->playerHealthRepository = $playerHealthRepository;
        $this->resourceRepository = $resourceRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $this->classroomAcademicYearAlumnRepository = $classroomAcademicYearAlumnRepository;
        $this->evaluationResultRepository = $evaluationResultRepository;
        $this->dailyControlRepository = $dailyControlRepository;
        $this->dailyControlItemRepository = $dailyControlItemRepository;
        $this->evaluationResultService = $evaluationResultService;
        $this->tutorshipService = $tutorshipService;
        $this->resourceService = $resourceService;
        $this->addressService = $addressService;
        $this->familyService = $familyService;
        $this->injuryService = $injuryService;
        $this->helper = $helper;
    }

    /**
     * Retrieves the list of players related to a team
     * 
     * @return array
     */
    public function index($requestData, $classroom)
    {
        try {
            $classroomAcademicYearId = $requestData['classroom_academic_year_id']
                ?? $classroom->activeAcademicYears->first()->pivot->id;

            $classroomYear = $this->classroomAcademicYearRepository->findOneBy([
                'id' => $classroomAcademicYearId
            ]);

            return $classroomYear->alumns;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Inserts player information into the database
     *
     * @return object
     */
    public function store(
        $alumnData,
        $alumnAddressData,
        $motherData,
        $fatherData,
        $addressData,
        $image,
        $statusId
    ) {
        try {
            // Stores the image in case is sent
            if (isset($image)) {
                $dataResource = $this->uploadResource('/alumns', $image);
                $resource = $this->resourceRepository->create($dataResource);
                if ($resource) {
                    $alumnData['image_id'] = $resource->id;
                }
            }

            if (isset($alumnData['academical_emails'])) {
                $alumnData['academical_emails'] = $this->helper->stringArrayParser(
                    $alumnData['academical_emails']
                );
            }

            // Stores a new alumn and registers its information
            $alumn = $this->alumnRepository->create($alumnData);
            $this->addressService->store($alumnAddressData, $alumn);

            // Stores a family registry
            $family = $this->familyService->store($statusId, $alumn);
            $parsedFamilyAddress = $this->parseMemberData($addressData, 'family_address');
            $this->addressService->store($parsedFamilyAddress, $family);

            // Parses mother information and stores it into database
            $parsedMotherData = $this->parseMemberData($motherData, 'mother');
            $this->familyService->manageMember($family, $parsedMotherData, 'mother');

            // Parses father information and stores it into the database
            $parsedFatherData = $this->parseMemberData($fatherData, 'father');
            $this->familyService->manageMember($family, $parsedFatherData, 'father');

            if (isset($alumnData['pending_subjects'])) {
                $subjectIds = $this->helper->stringArrayParser(
                    $alumnData['pending_subjects']
                );

                $this->upsertSubject($alumn->id, $subjectIds);
            }

            if (isset($alumnData['sports_played'])) {
                $sportIds = $this->helper->stringArrayParser(
                    $alumnData['sports_played']
                );

                $this->upsertSports($alumn->id, $sportIds);
            }

            return $alumn;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Retrieves information about specific alumn
     *
     * @return object
     */
    public function show($alumn)
    {
        try {
            $alumn->age;
            $alumn->bmi;
            $alumn->max_heart_rate;
            $alumn->gender;
            $alumn->image;
            $alumn->address;
            $alumn->sports;
            $alumn->pendingSubjects;
            $alumn->family;
            $alumn->family->members ?? null;
            $alumn->family->address ?? null;

            return $alumn;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Updates information about alumn in database
     *
     * @return bool|object
     */
    public function update($alumn, $alumnData, $alumnAddressData, $motherData,
        $fatherData, $addressData, $image, $statusId) 
    {
        try {
            $deletableImageId = null;

            if (isset($image)) {
                $dataResource = $this->uploadResource('/alumns', $image);

                $resource = $this->resourceRepository->create($dataResource);

                if ($resource) {
                    $alumnData['image_id'] = $resource->id;
                }

                $deletableImageId = $alumn->image_id;
            }

            if (isset($alumnData['academical_emails'])) {
                $alumnData['academical_emails'] = $this->helper->stringArrayParser(
                    $alumnData['academical_emails']
                );
            }

            // Do a basic update on the alumn information
            $this->alumnRepository->update($alumnData, $alumn);

            if ($deletableImageId) {
                $this->resourceService->deleteResourceData($deletableImageId);
            }

            // Update the address
            $this->addressService->update($alumnAddressData, $alumn);

            // In case the alumn has no previous family it stores a new registry
            $family = !$alumn->family
                ? $this->familyService->store($statusId, $alumn)
                : $this->familyService->update($statusId, $alumn);

            $parsedFamilyAddress = $this->parseMemberData($addressData, 'family_address');

            ( !$alumn->family->address ) ?
                $this->addressService->store($parsedFamilyAddress, $family):
                $this->addressService->update($parsedFamilyAddress, $alumn->family);

            // Parses mother information and manages it into database
            $parsedMotherData = $this->parseMemberData($motherData, 'mother');
            $this->familyService->manageMember($family, $parsedMotherData, 'mother');

            // Parses father information and manages it into the database
            $parsedFatherData = $this->parseMemberData($fatherData, 'father');
            $this->familyService->manageMember($family, $parsedFatherData, 'father');

            if (isset($alumnData['pending_subjects'])) {
                $subjectIds = $this->helper->stringArrayParser(
                    $alumnData['pending_subjects']
                );

                $this->upsertSubject($alumn->id, $subjectIds, 'update');
            }

            if (isset($alumnData['sports_played'])) {
                $sportIds = $this->helper->stringArrayParser(
                    $alumnData['sports_played']
                );

                $this->upsertSports($alumn->id, $sportIds, 'update');
            }

            // Insert the related activity
            // $this->helper->insertActivity($alumn, 'alumn_updated', $alumn->getRelatedActivtyEntities());

            $updated_alumn = $this->alumnRepository->findOneBy(['id' => $alumn->id]);
            $updated_alumn->age;
            $updated_alumn->bmi;
            $updated_alumn->max_heart_rate;
            $updated_alumn->gender;
            $updated_alumn->image;
            $updated_alumn->address;
            $updated_alumn->sports;
            $updated_alumn->pendingSubjects;
            $updated_alumn->family;
            $updated_alumn->family->members ?? null;
            $updated_alumn->family->address ?? null;

            return $updated_alumn;

        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Deletes an alumn
     *
     * @return bool|object
     */
    public function delete($alumnId)
    {
        try {
            // $this->helper->insertActivity($player, 'player_deleted', $player->getRelatedActivtyEntities());
            $this->classroomAcademicYearService->remove($alumnId);
            return $this->alumnRepository->delete($alumnId);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Keeps same values but replaces item keys by removing the string
     * sent by $type parameter
     *
     * @param array $data
     * @param string $type
     * @return array
     */
    private function parseMemberData($data, $type)
    {
        $parsedData = [];

        foreach ($data as $key => $value) {
            $parsedKey = str_replace($type . '_', '', $key);
            $parsedData[$parsedKey] = $value;
        }

        return $parsedData;
    }

    /**
     * Private method to insert sport relations on the alumn model
     *
     * @return void
     */
    private function upsertSubject($alumnId, $subjectIds, $type = 'create')
    {
        // Erase previous data in case of updating
        if ($type == 'update') {
            $this->alumnSubjectRepository->deleteByCriteria([
                'alumn_id' => $alumnId,
            ]);
        }

        foreach ($subjectIds as $subjectId) {
            $this->alumnSubjectRepository->create([
                'alumn_id' => $alumnId,
                'subject_id' => $subjectId
            ]);
        }
    }

    /**
     * Private method to insert sport relations on the alumn model
     *
     * @return void
     */
    private function upsertSports($alumnId, $sportIds, $type = 'create')
    {
        // Erase previous data in case of updating
        if ($type == 'update') {
            $this->alumnSportRepository->deleteByCriteria([
                'alumn_id' => $alumnId,
            ]);
        }

        foreach ($sportIds as $sportId) {
            $this->alumnSportRepository->create([
                'alumn_id' => $alumnId,
                'sport_id' => $sportId
            ]);
        }
    }

    public function resume($alumn_id, $classroom_academic_year_id)
    {
        /**
         * la información del alumno. ✅
         * Total de asistencias.✅
         * Total de inasistencias✅
         * Total de evaluaciones presentada. ✅
         * Notas total de las evaluaciones presentada. ✅
         * Notas total acumulada por competencia, agregar detalle de competencia.
         * Total de tutorías.✅
         * Ultima evaluación realizada con detalle. ✅
         * Totales de lesiones. ✅
         */

        try {
            $alumn = $this->alumnRepository->findOneBy(['id' => $alumn_id]);

            if (!$alumn) {
                throw new ModelNotFoundException;
            }

            $alumn->address;
            $alumn->family;
            $alumn->family->members ?? null;
            $alumn->family->address ?? null;

            $tutorships = $this->tutorshipService->getTutorshipsByAlumns($alumn_id);

            $evaluationsByAlumn = $this->evaluationResultRepository
                ->evaluationsByAlumn($alumn_id, $classroom_academic_year_id);

            $latestEvaluationsByAlumn = $this->evaluationResultRepository
                ->latestEvaluationByAlumn($alumn_id, $classroom_academic_year_id);

            $evaluationsSum = $evaluationsByAlumn->sum(function ($evaluation) {
                return floatval($evaluation->evaluation_grade);
            });

            $competence_results = [];
           
            if ($latestEvaluationsByAlumn) {
                $competence_results = $this->evaluationResultService->getResultByCompetences(
                    $latestEvaluationsByAlumn->evaluation_rubric_id,
                    $alumn_id,
                    $latestEvaluationsByAlumn->classroom_academic_year_id
                );
            }

            $daily_controls = $this->dailyControlRepository->findAlumnItems($alumn_id, $classroom_academic_year_id,
                null, null);

            $absences = collect($daily_controls)
                ->filter(function ($item) {
                    return $item->daily_control_item_id == 5 || $item->daily_control_item_id == 6;
                })
                ->sum('count');
            
            $alumn->address;
            $alumn->family;
            $alumn->favoriteSport;
            $alumn->sports;
            $alumn->pendingSubjects;

            return [
                'alumn' => $alumn,
                'total_evaluations' => count($evaluationsByAlumn),
                'total_tutorships' => count($tutorships['tutorships']),
                'absences' => $absences,
                'evaluations' => $evaluationsByAlumn,
                'evaluations_average' => $evaluationsByAlumn->count() == 0 ? 0 : floatval($evaluationsSum / $evaluationsByAlumn->count()),
                'competences_result' => $competence_results,
                'latest_evaluation' => $latestEvaluationsByAlumn,
                'lastet_injury' => $this->injuryService->lastInjuryByAlumn($alumn->id),
                'injuries_history' => $this->injuryService->injuriesLocationsByAlumn($alumn->id),
                'health_status' => $this->hasHealtStatus($alumn)
            ];
        } catch (ModelNotFoundException $exception) {
            throw $exception;
        }
    }

    public function resumes($classroom_academic_year_id)
    {
        /**
         * la información del alumno. ✅
         * Total de asistencias.✅
         * Total de inasistencias✅
         * Total de evaluaciones presentada. ✅
         * Notas total de las evaluaciones presentada. ✅
         * Notas total acumulada por competencia, agregar detalle de competencia.
         * Total de tutorías.✅
         */
        $alumns = $this->classroomAcademicYearAlumnRepository
            ->findBy(['classroom_academic_year_id' => $classroom_academic_year_id])
            ->pluck('alumn_id')
            ->toArray();

        $response = [];

        foreach ($alumns as $alumn_id) {
            try {
                $alumn = $this->alumnRepository->findOneBy(['id' => $alumn_id]);

                if (!$alumn) {
                    throw new ModelNotFoundException;
                }

                $tutorships = $this->tutorshipService->getTutorshipsByAlumns($alumn_id);

                $evaluationsByAlumn = $this->evaluationResultRepository->evaluationsByAlumn($alumn_id,
                    $classroom_academic_year_id);

                $evaluationsSum = $evaluationsByAlumn->sum(function ($evaluation) {
                    return number_format($evaluation->evaluation_grade, 2);
                });

                $daily_controls = $this->dailyControlRepository->findAlumnItems($alumn_id, $classroom_academic_year_id,
                    null, null);

                $absences = collect($daily_controls)
                    ->filter(function ($item) {
                        return $item->daily_control_item_id == 5 || $item->daily_control_item_id == 6;
                    })
                    ->sum('count');

                $response[] = [
                    'alumn' => $alumn,
                    'total_evaluations' => count($evaluationsByAlumn),
                    'total_tutorships' => count($tutorships['tutorships']),
                    'absences' => $absences,
                    'evaluations_average' => $evaluationsByAlumn->count() == 0 ? 0 : number_format($evaluationsSum / $evaluationsByAlumn->count(), 2)
                ];
            } catch (ModelNotFoundException $exception) {
                throw $exception;
            }
        }
        return $response;
    }

     /**
     * Return alumns with test by classroom academic year
     * @param $classroomAcademicYearId
     * @return Collection
     */
    public function allAlumnsTestByClassroomAcademicYear($classroomAcademicYearId)
    {
        $classroomYear = $this->classroomAcademicYearRepository->findOneBy([
            'id' => $classroomAcademicYearId
        ]);

        $alumns = $classroomYear->alumns;
        
        foreach ($alumns as $alumn) {
            $alumn->latestTestApplication;
            $alumn->latestTestApplication->test ?? null;
            $alumn->test_applications_count = $alumn->testApplications->count();
            $alumn->makeHidden([
                'is_new_entry', 'academical_emails', 'virtual_space', 'is_advanced_course', 'is_repeater',
                'is_delegate', 'is_sub_delegate', 'has_digital_difficulty', 'acneae_type_text', 'acneae_type_id',
                'acneae_subtype_id','acneae_description', 'has_sport', 'has_extracurricular_sport',
                'has_federated_sport', 'favorite_sport_id', 'favoriteSport', 'has_pending_physical_education',
                'country_id', 'list_number', 'heart_rate', 'max_heart_rate', 'genderIdentity', 'email', 'height',
                'weight', 'gender_identity_id', 'testApplications',
            ]);
        }

        return $alumns;
    }

    /**
     * Verified healt status alumn
     *
     * @param $alumn
     */
    private function hasHealtStatus($alumn)
    {
        $diseases = $alumn->diseases->count();
        $allergies = $alumn->allergies->count();
        $body_areas = $alumn->bodyAreas->count();
        $physical_problems = $alumn->physicalProblems->count();
        $medicine_types = $alumn->medicineTypes->count();
        $surgeries = $alumn->surgeries->count();

        return $diseases > 0 || $allergies > 0 ||
                $body_areas > 0 || $physical_problems > 0 ||
                $medicine_types > 0 || $surgeries > 0;
    }
}
