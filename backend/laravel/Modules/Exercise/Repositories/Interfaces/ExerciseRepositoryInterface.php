<?php

namespace  Modules\Exercise\Repositories\Interfaces;

interface ExerciseRepositoryInterface
{
    public function findByTeamFilterAndOrder($team, $params);

    public function findByEntity($requestParams, $entity);

    public function listByUserWithFilters(int $userId, array $filters);
}
