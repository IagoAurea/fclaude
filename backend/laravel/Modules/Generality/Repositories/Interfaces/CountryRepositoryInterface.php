<?php

namespace  Modules\Generality\Repositories\Interfaces;

interface CountryRepositoryInterface
{
    public function findTranslatedByTerm($term = null);
}