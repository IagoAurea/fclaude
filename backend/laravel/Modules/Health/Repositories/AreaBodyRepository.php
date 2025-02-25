<?php

namespace Modules\Health\Repositories;

use App\Services\ModelRepository;
use Modules\Health\Entities\AreaBody;
use Modules\Health\Repositories\Interfaces\AreaBodyRepositoryInterface;

class AreaBodyRepository extends ModelRepository implements AreaBodyRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'areas_body';

    /**
     * @var string
    */
    protected $tableTranslations = 'area_body_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'area_body_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(AreaBody $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return area body translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }


}
