<?php

namespace Modules\Tutorship\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Modules\Club\Entities\ClubType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;
use Modules\Alumn\Repositories\Interfaces\AlumnRepositoryInterface;
use Modules\Tutorship\Services\Interfaces\TutorshipServiceInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomRepositoryInterface;
use Modules\Tutorship\Repositories\Interfaces\TutorshipRepositoryInterface;
use Modules\Classroom\Repositories\Interfaces\ClassroomAcademicYearRepositoryInterface;

class TutorshipService implements TutorshipServiceInterface
{
    protected $tutorshipRepository;
    protected $classroomRepository;
    protected $classroomAcademicYearRepository;
    protected $clubRepository;
    protected $alumnRepository;

    /**
     * Instances a new controller class
     * 
     * @param TutorshipRepositoryInterface $tutorshipRepository
     * @param ClassroomRepositoryInterface $classroomRepositoryInterface
     * @param ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository
     * @param ClubRepositoryInterface $clubRepository
     * @param AlumnRepositoryInterface $alumnRepository
     */
    public function __construct(
        TutorshipRepositoryInterface $tutorshipRepository,
        ClassroomRepositoryInterface $classroomRepository,
        ClassroomAcademicYearRepositoryInterface $classroomAcademicYearRepository,
        AlumnRepositoryInterface $alumnRepository,
        ClubRepositoryInterface $clubRepository
    ) {
        $this->tutorshipRepository = $tutorshipRepository;
        $this->classroomRepository = $classroomRepository;
        $this->classroomAcademicYearRepository = $classroomAcademicYearRepository;
        $this->clubRepository = $clubRepository;
        $this->alumnRepository = $alumnRepository;
    }

     /**
     * Retrieve all tutorships create by players
     */
    public function allTutorshipsByUser($user_id)
    {
        $schools_center = $this->clubRepository
            ->findUserClubs($user_id, ClubType::CLUB_TYPE_ACADEMIC, [], ['classrooms']);

        $total_tutorships = $schools_center->map(function ($school_center) {
            return $school_center->classrooms->map(function ($classroom) {
                $classroom->academicYears = $this->classroomAcademicYearRepository
                    ->byClassroomIdAndYearIds($classroom->id);
                
                return $classroom->academicYears->map(function ($academicYear) {
                    $academicYear->makeHidden(['academicYear', 'classroom', 'tutor', 'physicalTeacher', 'subject']);

                    return $academicYear->alumns->map(function ($alumn) {
                        $alumn->tutorships = $this->tutorshipRepository->findBy([
                            'alumn_id' => $alumn->id
                        ]);

                        return $alumn->tutorships->count();
                    })->sum();
                })->sum();
            })->sum();
        })->sum();

        return [
            'schools_center' => $schools_center,
            'total_tutorships' => $total_tutorships ?? 0
        ];
    }

    /**
     * Returns a list of tutorships by their school center
     */
    public function getListOfTutorshipsBySchoolCenter($school_center_id)
    {
        return $this->tutorshipRepository->findBy(['club_id' => $school_center_id]);
    }

    /**
     * Returns a list of tutorships by their school center and alumns
     */
    public function getListOfTutorshipsBySchoolCenterAndAlumns($school_center_id)
    {
        $classrooms = $this->classroomRepository->findBy(['club_id' => $school_center_id]);
        $classroom_academic_years = $classrooms->flatMap(function ($classroom) {
            return $classroom->activeAcademicYears->map->classroom_academic_year_id;
        })->toArray();

        $alumns = $this->classroomAcademicYearRepository
            ->findIn('id', $classroom_academic_years)
            ->flatMap(function ($classroom_academic_year) {
                return $classroom_academic_year->alumns;
            });

        return $alumns->map(function ($alumn) {
            return $alumn->load('tutorships');
        });
    }

    /**
     * Returns a list of tutorships by their school center and teachers
     */
    public function getListOfTutorshipsBySchoolCenterAndTeachers($school_center_id)
    {
        $club = $this->clubRepository->findOneBy(['id' => $school_center_id]);

        if (!$club) {
            return [];
        }

        return $club->teachers->load('tutorships');
    }

    /**
     * Returns a list of tutorships by their school center and teachers
     */
    public function getTutorshipsByAlumns($alumn_id)
    {
        $alumn = $this->alumnRepository->findOneBy(['id' => $alumn_id]);

        if (!$alumn) {
            throw new ModelNotFoundException;
        }
        $tutorships = $this->tutorshipRepository->findByAlumn($alumn_id);

        return [
            'alumn' => $alumn,
            'tutorships' => $tutorships
        ];
    }

    /**
     * Returns a tutorships by a given id
     */
    /**
     * @OA\Response(
     *      response="tutorshipNotFound",
     *      description="Return when a specific tutorship is not found.",
     *      @OA\JsonContent(
     *          @OA\Property(property="success", type="string", example="false"),
     *          @OA\Property(property="message", type="string", example="The tutorship 999 does not exist."),
     *      )
     *  )
     */
    public function getTutorshipById($id)
    {
        return $this->tutorshipRepository->getInfoById($id);
    }

    /**
     * Stores a new tutorship
     */
    public function store($school_center_id, $payload)
    {
        $payload['club_id'] = $school_center_id;

        return $this->tutorshipRepository->create($payload);
    }

    /**
     * Updates a new tutorship
     */
    public function update($tutorship_id, $payload)
    {
        $tutorship = $this->tutorshipRepository->find($tutorship_id);

        if (!$tutorship) {
            throw new ModelNotFoundException();
        }

        return $tutorship->update($payload);
    }

    /**
     * Destroys a tutorship
     */
    public function destroy($id)
    {
        return $this->tutorshipRepository->delete($id);
    }

    /**
     * @OA\Response(
     *     response="tutorshipPdf",
     *     description="Generates a pdf report of the tutorship",
     *     @OA\MediaType(
     *         mediaType="application/pdf",
     *         @OA\Schema(
     *            type="string",
     *            format="binary"
     *         )
     *     )
     * )
     */
    public function generatePdf($id)
    {
        $data = $this->tutorshipRepository->getInfoById($id);

        if (!$data) {
            throw new ModelNotFoundException;
        }

        $dompdf = App::make('dompdf.wrapper');
        $pdf = $dompdf->loadView('tutorship::tutorship-detail', compact('data'));

        return new Response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="' . sprintf('tutorship-%s.pdf', $id) . '"',
            'Content-Length' => null,
        ]);

    }


    /**
     * @OA\Response(
     *     response="tutorshipPdfs",
     *     description="Generates multiple pdf reports of the tutorship",
     *     @OA\MediaType(
     *         mediaType="application/pdf",
     *         @OA\Schema(
     *            type="string",
     *            format="binary"
     *         )
     *     )
     * )
     */
    public function generatePdfs($alumn_id)
    {
        $data = $this->tutorshipRepository->findByAlumn($alumn_id);

        if (!$data) {
            throw new ModelNotFoundException;
        }

        $dompdf = App::make('dompdf.wrapper');
        $pdf = $dompdf->loadView('tutorship::tutorships-detail', compact('data'));

        return new Response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="' . sprintf('tutorships-%s.pdf', $alumn_id) . '"',
            'Content-Length' => null,
        ]);
    }

    /**
     * @OA\Response(
     *     response="generatePdfTest",
     *     description="Generates a pdf report of the tutorship",
     *     @OA\MediaType(
     *         mediaType="application/pdf",
     *         @OA\Schema(
     *            type="string",
     *            format="binary"
     *         )
     *     )
     * )
     */
    public function generatePdfTest($id)
    {
        $data = $this->tutorshipRepository->getInfoById($id);

        if (!$data) {
            throw new ModelNotFoundException;
        }

        $dompdf = App::make('dompdf.wrapper');
        $pdf = $dompdf->loadView('tutorship::tutorship-detail-test', compact('data'));

        return new Response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' =>  'attachment; filename="' . sprintf('tutorship-%s.pdf', $id) . '"',
            'Content-Length' => null,
        ]);
    }
}
