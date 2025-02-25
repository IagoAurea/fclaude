<?php

namespace Modules\Health\Repositories;

use App\Services\ModelRepository;
use Modules\Health\Entities\TypeMedicine;
use Modules\Health\Repositories\Interfaces\TypeMedicineRepositoryInterface;

class TypeMedicineRepository extends ModelRepository implements TypeMedicineRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'type_medicines';

    /**
     * @var string
    */
    protected $tableTranslations = 'type_medicine_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'type_medicine_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(TypeMedicine $model)
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