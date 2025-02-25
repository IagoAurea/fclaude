<?php

namespace Modules\Test\Repositories;

use App\Services\ModelRepository;
use Modules\Test\Entities\Response;
use Modules\Test\Repositories\Interfaces\ResponseRepositoryInterface;

class ResponseRepository extends ModelRepository implements ResponseRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'responses';

    /**
     * @var string
    */
    protected $tableTranslations = 'response_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'response_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(
        Response $model
    )
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return Response type translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

}