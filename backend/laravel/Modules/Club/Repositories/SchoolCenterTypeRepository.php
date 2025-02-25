<?php

namespace Modules\Club\Repositories;

use Modules\Club\Repositories\Interfaces\SchoolCenterTypeRepositoryInterface;
use Modules\Club\Entities\SchoolCenterType;
use App\Services\ModelRepository;

class SchoolCenterTypeRepository extends ModelRepository implements SchoolCenterTypeRepositoryInterface
{
     /**
     * @var string
    */
    protected $table = 'school_center_types';

    /**
     * @var string
    */
    protected $tableTranslations = 'school_center_type_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'school_center_type_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(SchoolCenterType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}