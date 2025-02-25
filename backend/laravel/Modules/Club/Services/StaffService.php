<?php

namespace Modules\Club\Services;

use Exception;
use App\Traits\ResponseTrait;
use Modules\Club\Repositories\Interfaces\WorkingExperiencesRepositoryInterface;
use Modules\Club\Repositories\Interfaces\ClubUserRepositoryInterface;
class StaffService 
{
    use ResponseTrait;

    /**
     * @var $workingExperiencesRepository
     */
    protected $workingExperiencesRepository;

    /**
     * @var $clubUserRepository
     */
    protected $clubUserRepository;

    public function __construct(
        WorkingExperiencesRepositoryInterface $workingExperiencesRepository,
        ClubUserRepositoryInterface $clubUserRepository
    ) {
        $this->workingExperiencesRepository = $workingExperiencesRepository;
        $this->clubUserRepository = $clubUserRepository;
    }

    /**
     * Response success
     * @param string $experiences
     * @param int $staff_id
     * @return array
     */
    public function createUpdateWorkinExperiences($experiences, $staff_id)
    {     
        try {

            $workingExperiences = json_decode($experiences, $staff_id);

            foreach ( $workingExperiences as $workingExperience ) {
                $workingExperience['staff_id'] = $staff_id;
                $this->workingExperiencesRepository->updateOrCreate((array)$workingExperience);
            }
            
            return $this->success('Working Experiences stored');

        } catch(Exception $exception) {

            return $this->error($exception->getMessage());

        }

    }

    /**
     * 
     * @param int $auth_id
     * @param int $club_id
     * @param int $clubUserTypeService
     * @return string
     */
    public function createClubUser($auth_id, $club_id, $clubUserTypeService)
    {     
        try {

            $clubUserData = [
                "user_id" => $auth_id,
                "club_id" => $club_id,
                "club_user_type_id" => $clubUserTypeService
            ];

            $this->clubUserRepository->updateOrCreate($clubUserData);
            
            return $this->success('Club-User stored');

        } catch(Exception $exception) {

            return $this->error($exception->getMessage());

        }

    }

    /**
     * 
     * @param string $string
     * @return json
     */
    public function stringToJson($string)
    {     
        try {

            $string = json_decode($string);

            return $string;

        } catch(Exception $exception) {

            return $this->error($exception->getMessage());

        }

    }

}