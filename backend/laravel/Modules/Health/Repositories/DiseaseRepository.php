<?php

namespace Modules\Health\Repositories;

use App\Services\ModelRepository;
use Modules\Health\Entities\Disease;
use Modules\Health\Repositories\Interfaces\DiseaseRepositoryInterface;

class DiseaseRepository extends ModelRepository implements DiseaseRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'diseases';

    /**
     * @var string
    */
    protected $tableTranslations = 'disease_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'disease_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(Disease $model)
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