<?php

namespace  Modules\Player\Repositories\Interfaces;

interface PunctuationRepositoryInterface
{
    public function findAllTranslated(); 

    public function getPunctuationPerfomanceAssessment(Int $point);

}