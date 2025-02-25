<?php

namespace  Modules\Test\Repositories\Interfaces;

interface TestRepositoryInterface
{
    public function findAllTranslated();

    public function findTestAll($test_id, $_locale);

    public function findAllImage($request);
}
