<?php

namespace Modules\Club\Repositories\Interfaces;

interface ClubRepositoryInterface
{
    public function findUserClubs($userId, $clubTypeId, $teamIds, $relations);

    public function getClubById($clubId);

    public function getClubActivities ($clubId);

    public function getClubMembers($id);

    public function findByOwner($email);
}