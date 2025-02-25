<?php

namespace Modules\SchoolCenter\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

// Entites
use Modules\User\Entities\User;

class SchoolPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(User $user)
    {
        return true;
    }
}
