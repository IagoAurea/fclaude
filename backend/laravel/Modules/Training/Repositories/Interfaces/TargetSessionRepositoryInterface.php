<?php

namespace  Modules\Training\Repositories\Interfaces;

interface TargetSessionRepositoryInterface
{
    public function findAllTranslated();

    public function findAllByContent($content_exercise_code,$sport_code);
    
    public function findAllBySubContent($sub_content_session_code,$sport_code);
}