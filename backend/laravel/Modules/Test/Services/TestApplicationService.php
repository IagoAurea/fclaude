<?php

namespace Modules\Test\Services;

use Exception;
use App\Traits\ResponseTrait;
use Modules\Alumn\Entities\Alumn;
use Modules\Test\Entities\Test;
use Modules\Club\Entities\ClubType;
use Modules\Player\Entities\Player;
use Modules\Test\Repositories\Interfaces\TestRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Test\Repositories\Interfaces\TestApplicationRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class TestApplicationService
{
    use ResponseTrait;

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
     * Repository
     * @var $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;

    /**
     * @var $helper
     */
    protected $helper;

    public function __construct(
        TestRepositoryInterface $testRepository,
        TestApplicationRepositoryInterface $testApplicationRepository,
        ClubRepositoryInterface $clubRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository

    ) {
        $this->testRepository = $testRepository;
        $this->testApplicationRepository = $testApplicationRepository;
        $this->clubRepository = $clubRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
    }


     /**
     * Retrieve all tests create by players
     */
    public function allTestsByUser($user_id, $type = 'team')
    {
        $club_type = $type == 'team' ? ClubType::CLUB_TYPE_SPORT : ClubType::CLUB_TYPE_ACADEMIC;

        $relations = $type == 'team' ? ['teams'] : ['classrooms'];

        $clubs = $this->clubRepository->findUserClubs($user_id, $club_type, [], $relations);

        $relations_hidden = ['users'];

        if($type != 'team') {array_push($relations_hidden, 'teams'); }

        $clubs->makeHidden($relations_hidden);

        $total_tests = $type == 'team' ?
            $this->totalTestsTeam($clubs) :
            $this->totalTestsClassroom($clubs);

        return [
            'clubs' => $clubs,
            'total_tests' => $total_tests ?? 0
        ];
    }

    /**
     * Calculate total tests by classroom
     */
    private function totalTestsClassroom($schools_center)
    {
        return $schools_center->map(function ($school_center) {
            return $school_center->classrooms->map(function ($classroom) {
                $classroom->academicYears = $this->classroomAcademicYearRepository
                    ->byClassroomIdAndYearIds($classroom->id);
                
                return $classroom->academicYears->map(function ($academicYear) {
                    $academicYear->makeHidden(['academicYear', 'classroom', 'tutor', 'physicalTeacher', 'subject']);
                    return $academicYear->alumns->map(function ($alumn) {
                        $alumn->tests = $this->testApplicationRepository->findBy([
                            'applicable_type' => Test::class,
                            'applicant_type' => Alumn::class,
                            'applicant_id' => $alumn->id
                        ]);

                        return $alumn->tests->count();
                    })->sum();
                })->sum();
            })->sum();
        })->sum();
    }

    /**
     * Calculate total tests by team
     */
    private function totalTestsTeam($clubs)
    {
        return $clubs->map(function ($club) {
            $club->teams->makeHidden(['sport', 'season', 'type']);

            return $club->teams->map(function ($team) {
                return $team->players->map(function ($player) {
                    $player->tests = $this->testApplicationRepository->findBy([
                        'applicable_type' => Test::class,
                        'applicant_type' => Player::class,
                        'applicant_id' => $player->id
                    ]);

                    return $player->tests->count();
                })->sum();
            })->sum();
        })->sum();
    }
}
