<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\Phase;
use Modules\Injury\Repositories\Interfaces\PhaseRepositoryInterface;

class PhaseRepository extends ModelRepository implements PhaseRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'phases';

    /**
     * @var string
    */
    protected $tableTranslations = 'phase_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'phase_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        Phase $model
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

