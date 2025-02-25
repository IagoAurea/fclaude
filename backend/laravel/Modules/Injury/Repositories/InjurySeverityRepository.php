<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjurySeverity;
use Modules\Injury\Repositories\Interfaces\InjurySeverityRepositoryInterface;

class InjurySeverityRepository extends ModelRepository implements InjurySeverityRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'injury_severities';

    /**
     * @var string
    */
    protected $tableTranslations = 'injury_severity_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'injury_severity_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(InjurySeverity $model)
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