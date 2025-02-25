<?php

namespace  Modules\Evaluation\Repositories\Interfaces;

interface CompetenceRepositoryInterface
{
    /**
     *  Return competences translations
     *
     * @return array
     */
    public function findAllTranslated();

    /**
     * @param int $id
     * @return array Returns a competence translated to the locale by a given id
     */
    public function findByIdTranslated($id);
}
