<?php

namespace Modules\Club\Repositories\Interfaces;

use Modules\Club\Entities\Club;
use Modules\User\Entities\User;

interface ClubInvitationRepositoryInterface
{
    public function getInvitationsByClub($clubId);

    public function getInvitationsByClubWithStaff($clubId,$search,$order,$filter);

    public function getClubInvitationsByCode($clubId);

    public function userHistory(Club $club, User $user);
}