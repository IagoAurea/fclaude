<?php

namespace  Modules\User\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getGenderTypes();

    public function getUser($id);

    public function getUserByEmail($email);

    public function totalMatchesUser($user_id);

    public function allMatchesByUser($user_id);
}