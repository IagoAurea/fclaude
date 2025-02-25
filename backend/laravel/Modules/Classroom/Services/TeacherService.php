<?php

namespace Modules\Classroom\Services;

use Modules\Classroom\Repositories\Interfaces\WorkingExperiencesRepositoryInterface;

class TeacherService
{
    /**
     * @var object $workingExperiencesRepository
     */
    protected $workingExperiencesRepository;

     /**
     * Instances a new service class
     *
     */
    public function __construct(WorkingExperiencesRepositoryInterface $workingExperiencesRepository)
    {
        $this->workingExperiencesRepository = $workingExperiencesRepository;
    }

    /**
     * Create working experiences teacher
     *
     * @param $teacherId
     * @param $workingExperiences
     */
    public function createWorkingExperiences($teacherId, $workingExperiences)
    {
        if(is_null($workingExperiences)) { return; }

        $this->workingExperiencesRepository->bulkDelete(['teacher_id' => $teacherId]);

        foreach (json_decode($workingExperiences, true) as $workingExperience) {
            $this->workingExperiencesRepository->create([
                'teacher_id' => $teacherId,
                'club' => $workingExperience['club'],
                'occupation' => $workingExperience['occupation'],
                'start_date' => $workingExperience['start_date'],
                'finish_date' => $workingExperience['finish_date']
            ]);
        }
    }
}