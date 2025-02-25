<?php

namespace Modules\Team\Observers;

use Modules\Club\Repositories\Interfaces\PositionStaffRepositoryInterface;
use Modules\Staff\Services\StaffService;
use Modules\Team\Entities\Team;

class TeamObserver
{
    /**
     * @var object $staffService
     */
    protected $staffService;

    /**
     * @var object $positionStaffRepository
     */
    protected $positionStaffRepository;

    /**
     * Creates a new observer instance
     */
    public function __construct(
        StaffService $staffService,
        PositionStaffRepositoryInterface $positionStaffRepository
    ) {
        $this->staffService = $staffService;
        $this->positionStaffRepository = $positionStaffRepository;
    }

    /**
     * Handle the User "created" event.
     *
     * @param  Team  $team
     * @return void
     */
    public function created(Team $team)
    {
        $userData = [
            'full_name' => $team->user->full_name,
            'email' => $team->user->email,
            'gender_id' => $team->user->gender_id
        ];

        $addressData = [
            'street' => $team->user->address,
            'city' => $team->user->city,
            'postal_code' => $team->user->zipcode,
            'country_id' => $team->user->country_id,
            'province_id' => $team->user->province_id,
            'phone' => $team->user->phone,
            'mobile_phone' => $team->user->mobile_phone
        ];

        $trainer = $this->positionStaffRepository->findOneBy(['code' => 'trainer']);

        $staffData = [
            'responsibility' => 'Trainer',
            'position_staff_id' => $trainer->id
        ];

        $this->staffService->store(
            $team,
            $userData,
            $addressData,
            $staffData
        );
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  Team  $team
     * @return void
     */
    public function updated(Team $team)
    {
        //
    }

    /**
     * Handle the alumn "deleted" event.
     *
     * @param  Team  $team
     * @return void
     */
    public function deleted(Team $team)
    {
        //
    }

    /**
     * Handle the alumn "forceDeleted" event.
     *
     * @param  Team  $team
     * @return void
     */
    public function forceDeleted(Team $team)
    {
        //
    }
}
