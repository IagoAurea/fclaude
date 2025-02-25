<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\TypeValoration;
use Modules\Test\Repositories\Interfaces\TypeValorationRepositoryInterface;

class TypeValorationRepository extends ModelRepository implements TypeValorationRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'type_valorations';

    /**
     * @var string
    */
    protected $tableTranslations = 'type_valoration_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'type_valoration_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        TypeValoration $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return test type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

}