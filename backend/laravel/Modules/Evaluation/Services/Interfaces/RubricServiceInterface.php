<?php

namespace Modules\Evaluation\Services\Interfaces;

interface RubricServiceInterface
{
    /**
     * Determinate if the total percentage of the
     * associated indicators is 100%
     *
     * @param array $ids
     * @return Boolean;
     */
    public function isValidIndicatorsPercentage($ids);

    public function allRubricsByUser($userId);

}
