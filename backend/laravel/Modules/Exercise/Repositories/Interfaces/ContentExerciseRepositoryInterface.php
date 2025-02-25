<?php

namespace  Modules\Exercise\Repositories\Interfaces;

interface ContentExerciseRepositoryInterface
{
	public function findAllTranslated();

    public function findAllSubcontentsWithTarget($sport_code);

}