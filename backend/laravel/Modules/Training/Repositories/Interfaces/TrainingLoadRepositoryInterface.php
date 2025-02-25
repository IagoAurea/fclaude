<?php

namespace  Modules\Training\Repositories\Interfaces;

interface TrainingLoadRepositoryInterface
{
    public function findOneByRangeDate($entity, $id, $today);

}