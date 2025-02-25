<?php

namespace Modules\Evaluation\Services;

use Modules\Club\Entities\ClubType;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Evaluation\Services\Interfaces\RubricServiceInterface;
use Modules\Evaluation\Exceptions\RubricIndicatorsIsInvalidException;
use Modules\Evaluation\Repositories\Interfaces\RubricRepositoryInterface;
use Modules\Evaluation\Repositories\Interfaces\IndicatorRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class RubricService implements RubricServiceInterface
{
    const VALID_TOTAL_INDICATOR_PERCENTAGE = 100;

    /**
     * Repository
     * @var $indicatorRepository
     */
    protected $indicatorRepository;

    /**
     * Repository
     * @var $rubricRepository
     */
    protected $rubricRepository;

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
        IndicatorRepositoryInterface $indicatorRepository,
        RubricRepositoryInterface $rubricRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository,
        ClubRepositoryInterface $clubRepository
    )
    {
        $this->indicatorRepository = $indicatorRepository;
        $this->rubricRepository = $rubricRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $this->clubRepository = $clubRepository;
    }

    /**
     * Retrieve all rubrics created by user
     */
    public function allRubricsByUser($userId)
    {

        $schools_center = $this->clubRepository->findUserClubs(
            $userId, ClubType::CLUB_TYPE_ACADEMIC, [], ['classrooms']);
        
        $schools_center->makeHidden('users');

        $total_rubrics = $schools_center->map(function($school_center) {
            return $school_center->classrooms->map(function($classroom) {
                $academicYears = $this->classroomAcademicYearRepository->byClassroomIdAndYearIds($classroom->id);

                return $academicYears->map(function ($academicYear) use($classroom) {
                    $academicYear->makeHidden(['academicYear', 'classroom', 'tutor', 'physicalTeacher', 'subject']);
                    
                    $classroom->rubrics = $this->rubricRepository->rubricsByClassroom($academicYear->id);

                    return $classroom->rubrics->map(function ($rubric) {
                        $rubric->makeHidden(['classrooms', 'indicators']);
                    })->count();
                })->sum();
            })->sum();
        })->sum();

        return [
            'schools_center' => $schools_center,
            'total_rubrics' => $total_rubrics
        ];
    }

    /**
     * Determinate if the total percentage of the
     * associated indicators is 100%
     * 
     * @param array $ids
     * @return void;
     * @throws RubricIndicatorsIsInvalidException;
     */
    public function isValidIndicatorsPercentage($ids)
    {
        if (empty($ids)) {
            throw new RubricIndicatorsIsInvalidException();
        }

        $indicators = $this->indicatorRepository->findIn('id', $ids);
        $total = $indicators->sum(function ($indicator) {
            return $indicator->percentage;
        });

        if ($total != self::VALID_TOTAL_INDICATOR_PERCENTAGE) {
            throw new RubricIndicatorsIsInvalidException($total);
        }
    }
}
