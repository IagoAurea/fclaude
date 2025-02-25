<?php

namespace Modules\Health\Repositories;

use App\Services\ModelRepository;
use Modules\Health\Entities\Allergy;
use Modules\Health\Repositories\Interfaces\AllergyRepositoryInterface;

class AllergyRepository extends ModelRepository implements AllergyRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'allergies';

    /**
     * @var string
    */
    protected $tableTranslations = 'allergy_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'allergy_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(Allergy $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return allergies translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }


}