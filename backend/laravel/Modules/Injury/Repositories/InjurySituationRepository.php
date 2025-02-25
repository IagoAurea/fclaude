<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjurySituation;
use Modules\Injury\Repositories\Interfaces\InjurySituationRepositoryInterface;

class InjurySituationRepository extends ModelRepository implements InjurySituationRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'injury_situations';

    /**
     * @var string
    */
    protected $tableTranslations = 'injury_situation_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'injury_situation_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(InjurySituation $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return diseases translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}