<?php

namespace Modules\Team\Repositories;

use Modules\Team\Repositories\Interfaces\TeamTypeRepositoryInterface;
use Modules\Team\Entities\TeamType;
use App\Services\ModelRepository;
use App\Traits\TranslationTrait;

class TeamTypeRepository extends ModelRepository implements TeamTypeRepositoryInterface
{
     /**
     * @var string
    */
    protected $table = 'team_type';

    /**
     * @var string
    */
    protected $tableTranslations = 'team_type_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'team_type_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(TeamType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return translations
     *
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}