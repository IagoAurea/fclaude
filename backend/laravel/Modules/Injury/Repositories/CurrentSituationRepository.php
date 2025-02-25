<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\CurrentSituation;
use Modules\Injury\Repositories\Interfaces\CurrentSituationRepositoryInterface;

class CurrentSituationRepository extends ModelRepository implements CurrentSituationRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'current_situations';

    /**
     * @var string
    */
    protected $tableTranslations = 'current_situation_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'current_situation_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        CurrentSituation $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return diet translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

}