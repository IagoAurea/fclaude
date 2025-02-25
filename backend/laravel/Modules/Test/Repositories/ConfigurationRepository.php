<?php

namespace Modules\Test\Repositories;

use Modules\Test\Entities\Configuration;
use App\Services\ModelRepository;
use Modules\Test\Repositories\Interfaces\ConfigurationRepositoryInterface;

class ConfigurationRepository extends ModelRepository implements ConfigurationRepositoryInterface
{
 /**
     * @var string
    */
    protected $table = 'configurations';

    /**
     * @var string
    */
    protected $tableTranslations = 'configuration_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'configuration_id';

    /**
     * @var object
    */
    protected $model;


    public function __construct(
        Configuration $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return Question type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }



    
}