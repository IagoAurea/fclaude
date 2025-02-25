<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\MechanismInjury;
use Modules\Injury\Repositories\Interfaces\MechanismInjuryRepositoryInterface;

class MechanismInjuryRepository extends ModelRepository implements MechanismInjuryRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'mechanisms_injury';

    /**
     * @var string
    */
    protected $tableTranslations = 'mechanism_injury_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'mechanism_injury_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(MechanismInjury $model)
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
