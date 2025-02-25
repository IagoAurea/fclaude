<?php

namespace Modules\Staff\Services;

use Exception;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

// Repositories
use Modules\Staff\Repositories\Interfaces\StaffWorkExperienceRepositoryInterface;

// Entities
use Modules\Staff\Entities\StaffUser;


class StaffWorkExperienceService 
{
    use ResponseTrait;

    /**
     * @var $workExperienceRepository
     */
    protected $workExperienceRepository;

    /**
     * Instance a new service class.
     */
    public function __construct(
        StaffWorkExperienceRepositoryInterface $workExperienceRepository
    ) {
        $this->workExperienceRepository = $workExperienceRepository;
    }

    /**
     * 
     */
    public function store(StaffUser $staff, $requestData)
    {
        try {
            $requestData['staff_user_id'] = $staff->id;
            return $this->workExperienceRepository->create($requestData);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * 
     */
    public function bulkStore(StaffUser $staff, $workHistory)
    {
        try {
            $workArray = json_decode($workHistory);

            foreach ($workArray as $work) {
                $this->store($staff, (array) $work);
            }

            return TRUE;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * 
     */
    public function bulkUpdate(StaffUser $staff, $workHistory)
    {
        try {
            $this->workExperienceRepository->deleteByCriteria([
                'staff_user_id' => $staff->id,
            ]);

            $this->bulkStore($staff, $workHistory);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
