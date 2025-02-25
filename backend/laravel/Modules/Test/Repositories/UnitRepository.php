<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\Unit;
use Modules\Test\Repositories\Interfaces\UnitRepositoryInterface;

class UnitRepository extends ModelRepository implements UnitRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'units';

    /**
     * @var string
    */
    protected $tableTranslations = 'unit_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'unit_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        Unit $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return Question type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }


}