<?php

namespace Modules\Player\Repositories;

use App\Services\ModelRepository;
use Modules\Player\Entities\ClubArrivalType;
use Modules\Player\Repositories\Interfaces\ClubArrivalTypeRepositoryInterface;

class ClubArrivalTypeRepository extends ModelRepository implements ClubArrivalTypeRepositoryInterface
{
    /**
     * @var string
    */
    protected $table = 'club_arrival_types';

    /**
     * @var string
    */
    protected $tableTranslations = 'club_arrival_type_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'club_arrival_type_id';

    /**
     * @var object
    */
    protected $model;

    public function __construct(ClubArrivalType $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     *  Return translations
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}