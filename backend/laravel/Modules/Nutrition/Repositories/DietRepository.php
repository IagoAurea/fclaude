<?php

namespace Modules\Nutrition\Repositories;

use App\Services\ModelRepository;
use Modules\Nutrition\Entities\Diet;
use Modules\Nutrition\Repositories\Interfaces\DietRepositoryInterface;

class DietRepository extends ModelRepository implements DietRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'diets';

    /**
     * @var string
    */
    protected $tableTranslations = 'diet_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'diet_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(Diet $model)
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