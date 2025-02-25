<?php

namespace  Modules\Generality\Repositories\Interfaces;

interface ProvinceRepositoryInterface
{
    public function findByCountryAndTranslated($country);
}