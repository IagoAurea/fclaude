<?php

namespace Modules\Club\Observers;

use Modules\Club\Repositories\Interfaces\PositionStaffRepositoryInterface;
use Modules\Staff\Services\StaffService;
use Modules\Club\Entities\Club;

class ClubObserver
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
     * @param  Club  $club
     * @return void
     */
    public function created(Club $club)
    {
        $userData = [
            'full_name' => $club->owner->full_name,
            'email' => $club->owner->email,
            'gender_id' => $club->owner->gender_id
        ];

        $addressData = [
            'street' => $club->owner->address,
            'city' => $club->owner->city,
            'postal_code' => $club->owner->zipcode,
            'country_id' => $club->owner->country_id,
            'province_id' => $club->owner->province_id,
            'phone' => $club->owner->phone,
            'mobile_phone' => $club->owner->mobile_phone
        ];

        $trainer = $this->positionStaffRepository->findOneBy(['code' => 'president']);

        $staffData = [
            'responsibility' => 'Owner',
            'position_staff_id' => $trainer->id
        ];

        $this->staffService->store(
            $club,
            $userData,
            $addressData,
            $staffData
        );
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  Club  $club
     * @return void
     */
    public function updated(Club $club)
    {
        //
    }

    /**
     * Handle the alumn "deleted" event.
     *
     * @param  Club  $club
     * @return void
     */
    public function deleted(Club $club)
    {
        //
    }

    /**
     * Handle the alumn "forceDeleted" event.
     *
     * @param  Club  $club
     * @return void
     */
    public function forceDeleted(Club $club)
    {
        //
    }
}
