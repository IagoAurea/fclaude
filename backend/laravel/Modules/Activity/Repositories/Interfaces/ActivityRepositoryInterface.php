<?php

namespace Modules\Activity\Repositories\Interfaces;

interface ActivityRepositoryInterface
{

   public function findAllByUser($user_id, $skip, $limit);

   public function findAllByTeam($team_id, $skip, $limit);

   public function findAllByUserClubs($clubs, $skip, $limit);

   public function findClubActivities($clubIds, $type);
}
