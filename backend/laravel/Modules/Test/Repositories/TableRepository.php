<?php

namespace Modules\Test\Repositories;

use Modules\Test\Entities\Table;
use App\Services\ModelRepository;
use Modules\Test\Repositories\Interfaces\TableRepositoryInterface;

class TableRepository extends ModelRepository implements TableRepositoryInterface
{
 /**
     * @var string
    */
    protected $table = 'tables';

    /**
     * @var string
    */
    protected $tableTranslations = 'table_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'table_id';

    /**
     * @var object
    */
    protected $model;


    public function __construct(
        Table $model
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