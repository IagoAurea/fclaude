<?php

namespace Modules\Alumn\Repositories;

use App\Services\ModelRepository;
use Modules\Alumn\Entities\AcneaeSubtype;
use Modules\Alumn\Repositories\Interfaces\AcneaeSubtypeRepositoryInterface;

class AcneaeSubtypeRepository extends ModelRepository implements AcneaeSubtypeRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'acneae_subtypes';

    /**
     * @var string
     */
    protected $tableTranslations = 'acneae_subtypes_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'acneae_subtype_id';

    /**
     * @var object
     */
    protected $model;

    /**
     * @var string
     */
    protected $fields = [
        'name',
        'tooltip'
    ];

    /**
     * Creates a new repository instance
     */
    public function __construct(AcneaeSubtype $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Return translated items
     * 
     * @return array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate, $this->fields);
    }
}
