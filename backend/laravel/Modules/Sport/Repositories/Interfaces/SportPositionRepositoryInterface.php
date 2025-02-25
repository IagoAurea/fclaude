<?php

namespace  Modules\Sport\Repositories\Interfaces;

interface SportPositionRepositoryInterface
{
    public function findAllTranslated($sportId);
}