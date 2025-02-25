<?php

namespace  Modules\Player\Repositories\Interfaces;

interface PlayerSkillsRepositoryInterface
{
   public function findSkillsByPlayer($player_id);
}