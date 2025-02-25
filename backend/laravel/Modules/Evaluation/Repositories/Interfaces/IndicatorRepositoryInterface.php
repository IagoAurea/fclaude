<?php

namespace  Modules\Evaluation\Repositories\Interfaces;

interface IndicatorRepositoryInterface
{
    public function assignCompetencesToIndicator($indicator_id, $competences);
}
