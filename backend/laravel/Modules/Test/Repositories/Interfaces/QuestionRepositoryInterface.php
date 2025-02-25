<?php

namespace  Modules\Test\Repositories\Interfaces;

interface QuestionRepositoryInterface
{
    public function findAllTranslated();

    public function questionTest($question_code, $test);

}