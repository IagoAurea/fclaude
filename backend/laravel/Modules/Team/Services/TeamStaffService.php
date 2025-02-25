<?php

namespace Modules\Team\Services;

use Exception;
use App\Traits\ResponseTrait;
use Modules\Team\Repositories\Interfaces\WorkingExperienceStaffRepositoryInterface;

class TeamStaffService 
{
    use ResponseTrait;

    /**
     * @var $workingExperiencesRepository
     */
    protected $workingExperiencesRepository;

    public function __construct(
        WorkingExperienceStaffRepositoryInterface $workingExperiencesRepository
    ) {
        $this->workingExperiencesRepository = $workingExperiencesRepository;
    }

    /**
     * Response success
     * @param array|string $experiences
     * @param int $team_staff_id
     * @return array
     */
    public function createUpdateWorkinExperiences($experiences, $staff_id)
    {     
        try {
            $workingExperiences = json_decode($experiences, $staff_id);

            foreach ( $workingExperiences as $workingExperience ) {
                $workingExperience['team_staff_id'] = $staff_id;
                $this->workingExperiencesRepository->create($workingExperience);
            }

            return $this->success('Working Experiences stored');
        } catch(Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}