<?php

namespace  Modules\Injury\Repositories\Interfaces;

interface InjuryRfdRepositoryInterface
{
   public function allInjuriesRfdByPlayer($player_id);
   
   public function getRfdAll($rdf_id);

   public function getRfdAdvance($rdf_id);

   public function listOfPlayersByRfd($teamId, $search,$order,$filter);

}