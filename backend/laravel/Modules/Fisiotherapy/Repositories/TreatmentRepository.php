<?php

namespace Modules\Fisiotherapy\Repositories;

use App\Services\ModelRepository;
use Modules\Fisiotherapy\Entities\Treatment;
use Modules\Fisiotherapy\Repositories\Interfaces\TreatmentRepositoryInterface;

class TreatmentRepository extends ModelRepository implements TreatmentRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'treatments';

    /**
     * @var string
    */
    protected $tableTranslations = 'treatment_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'treatment_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(Treatment $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return treatments translations
     *
     * @return array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}