<?php

namespace Modules\Nutrition\Repositories;

use App\Services\ModelRepository;
use Modules\Nutrition\Entities\Supplement;
use Modules\Nutrition\Repositories\Interfaces\SupplementRepositoryInterface;

class SupplementRepository extends ModelRepository implements SupplementRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'supplements';

    /**
     * @var string
    */
    protected $tableTranslations = 'supplement_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'supplement_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(Supplement $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return supplement translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

}