<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjuryLocation;
use Modules\Injury\Repositories\Interfaces\InjuryLocationRepositoryInterface;

class InjuryLocationRepository extends ModelRepository implements InjuryLocationRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'injury_locations';

    /**
     * @var string
    */
    protected $tableTranslations = 'injury_location_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'injury_location_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(InjuryLocation $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return injury location translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}