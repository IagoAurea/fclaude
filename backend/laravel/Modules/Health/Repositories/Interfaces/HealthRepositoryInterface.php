<?php

namespace  Modules\Health\Repositories\Interfaces;

interface HealthRepositoryInterface
{
  public function bulkDeleteRelations($player_id, $health_class);
}