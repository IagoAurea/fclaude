<?php

namespace Modules\Injury\Repositories;

use App\Services\ModelRepository;
use Modules\Injury\Entities\InjuryTypeSpec;
use Modules\Injury\Repositories\Interfaces\InjuryTypeSpecRepositoryInterface;

class InjuryTypeSpecRepository extends ModelRepository implements InjuryTypeSpecRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'injury_type_specs';

    /**
     * @var string
    */
    protected $tableTranslations = 'injury_type_spec_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'injury_type_spec_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(InjuryTypeSpec $model)
    {
        $this->model = $model;
        $this->relations = ['image'];

        parent::__construct($this->model, $this->relations);
    }

    /**
     *  Return diseases translations
     *
     */
    public function findAllTranslated($injuryTypeId)
    {
        return $this->model->where('injury_type_id', $injuryTypeId)
            ->with('image')
            ->withTranslation(app()->getLocale())
            ->get();
    }
}