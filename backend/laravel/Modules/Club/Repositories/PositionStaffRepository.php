<?php

namespace Modules\Club\Repositories;

use Modules\Club\Repositories\Interfaces\PositionStaffRepositoryInterface;
use Modules\Club\Entities\PositionStaff;
use App\Services\ModelRepository;

class PositionStaffRepository extends ModelRepository implements PositionStaffRepositoryInterface
{
     /**
     * @var string
    */
    protected $table = 'position_staff';

    /**
     * @var string
    */
    protected $tableTranslations = 'position_staff_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'position_staff_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(PositionStaff $model)
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