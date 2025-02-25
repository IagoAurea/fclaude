<?php

namespace  Modules\Training\Repositories\Interfaces;

interface SubContentSessionRepositoryInterface
{
    public function findAllTranslated();

    public function listByContent($code);
}