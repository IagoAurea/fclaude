<?php

namespace Modules\Test\Repositories;

use Modules\Test\Entities\TableDetail;
use App\Services\ModelRepository;
use Modules\Test\Repositories\Interfaces\TableDetailRepositoryInterface;

class TableDetailRepository extends ModelRepository implements TableDetailRepositoryInterface
{
 /**
     * @var string
    */
    protected $table = 'table_details';

    /**
     * @var string
    */
    protected $tableTranslations = 'table_detail_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'table_detail_id';

    /**
     * @var object
    */
    protected $model;


    public function __construct(
        TableDetail $model
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