<?php

namespace Modules\Alumn\Repositories;

use Modules\Alumn\Repositories\Interfaces\AcneaeTypeRepositoryInterface;
use Modules\Alumn\Entities\AcneaeType;
use Illuminate\Support\Facades\DB;
use App\Services\ModelRepository;

class AcneaeTypeRepository extends ModelRepository implements AcneaeTypeRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'acneae_types';

    /**
     * @var string
     */
    protected $tableTranslations = 'acneae_types_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'acneae_type_id';

    /**
     * @var string
     */
    protected $fields = [
        'name',
        'tooltip'
    ];

    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new repository instance
     */
    public function __construct(AcneaeType $model)
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
        return $this->model->with('subtypes')->get();
    }
}
