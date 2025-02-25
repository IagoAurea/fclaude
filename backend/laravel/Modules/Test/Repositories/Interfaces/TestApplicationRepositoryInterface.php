<?php

namespace  Modules\Test\Repositories\Interfaces;

interface TestApplicationRepositoryInterface
{
    public function createTestApplication($request);

    public function findTestApplicationAll($test_application_id, $full_relations);

    public function findFirstTestApplication($code);

    public function findPreviousApplication($test_application_id); 

    public function findAllPreviousApplications($test_application_id);

    public function findTestApplicationDetail($id);

}