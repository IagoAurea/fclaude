<?php

namespace Modules\Evaluation\Services;

use Modules\Club\Entities\ClubType;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Evaluation\Services\Interfaces\EvaluationGradeServiceInterface;
use Modules\Evaluation\Repositories\Interfaces\EvaluationGradeRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class EvaluationGradeService implements EvaluationGradeServiceInterface
{
    /**
     * Repository
     * @var $evaluationGradeRepository
     */
    protected $evaluationGradeRepository;

    /**
     * Repository
     * @var $classroomAcademicYearRepository
     */
    protected $classroomAcademicYearRepository;
    /**
     * @var object $clubRepository
     */
    protected $clubRepository;

    public function __construct(
        EvaluationGradeRepositoryInterface $evaluationGradeRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository,
        ClubRepositoryInterface $clubRepository
    )
    {
        $this->evaluationGradeRepository = $evaluationGradeRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $this->clubRepository = $clubRepository;
        ini_set('max_execution_time', 200);
    }

    /**
     * Retrieve all rubrics created by user
     */
    public function allEvaluationsByUser($userId)
    {

        $schools_center = $this->clubRepository->findUserClubs(
            $userId, ClubType::CLUB_TYPE_ACADEMIC, [], ['classrooms']);
        
        $schools_center->makeHidden('users');

        $total_evaluations = $schools_center->map(function($school_center) {
            return $school_center->classrooms->map(function($classroom) {
                $classroom->academicYears = $this->classroomAcademicYearRepository
                    ->byClassroomIdAndYearIds($classroom->id);

                return $classroom->academicYears->map(function ($academicYear) {
                    $academicYear->makeHidden(['academicYear', 'classroom', 'tutor', 'physicalTeacher', 'subject']);

                    return $academicYear->alumns->map(function ($alumn) use($academicYear) {
                        $alumn->evaluations = $this->evaluationGradeRepository
                            ->evaluationByAlumnClassroomAcademic($alumn->id, $academicYear->id);

                        $alumn->evaluations->map(function($evaluation) {
                            $evaluation->makeHidden('indicatorRubric');
                        });

                        return $alumn->evaluations->groupBy(['alumn_id', 'classroom_academic_year_id'])->count();
                    })->sum();

                })->sum();
            })->sum();
        })->sum();

        return [
            'schools_center' => $schools_center,
            'total_evaluations' => $total_evaluations
        ];
    }

}