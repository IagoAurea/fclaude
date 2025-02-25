<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\KinshipRepositoryInterface;
use Modules\Generality\Entities\Kinship;
use App\Services\ModelRepository;

class KinshipRepository extends ModelRepository implements KinshipRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    /**
     * @var string
    */
    protected $table = 'kinships';

    /**
     * @var string
    */
    protected $tableTranslations = 'kinship_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'kinship_id';

    public function __construct(Kinship $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

}