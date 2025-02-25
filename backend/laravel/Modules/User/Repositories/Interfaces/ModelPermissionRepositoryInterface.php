<?php

namespace  Modules\User\Repositories\Interfaces;

interface ModelPermissionRepositoryInterface
{
  public function listUserPermissions($userId, $entityId, $entityType);

  public function listEntityPermissions($entityType, $entityId, $extraIds);
}
