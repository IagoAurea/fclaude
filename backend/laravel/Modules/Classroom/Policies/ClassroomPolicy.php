<?php

namespace Modules\Classroom\Policies;

use Modules\User\Entities\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Club\Repositories\Interfaces\ClubRepositoryInterface;

class ClassroomPolicy
{
    use HandlesAuthorization;

    /**
     * @var $clubRepository
     */
    protected $clubRepository;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct(
        ClubRepositoryInterface $clubRepository,
    ) {
        $this->clubRepository = $clubRepository;
    }

    /**
     * Validate index function
     */
    public function index(User $user, $schoolCenterId)
    {
        $schoolCenter = $this->clubRepository->findOneBy(['id' =>  $schoolCenterId]);

        return $schoolCenter->user_id == $user->id
            ? Response::allow()
            : Response::deny(@trans('classroom::messages.policies.classroom.index.deny'));
    }
}
