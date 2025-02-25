<?php

namespace Modules\Scouting\Repositories;

use Modules\Scouting\Repositories\Interfaces\ActionRepositoryInterface;
use Modules\Scouting\Entities\Action;
use Illuminate\Support\Facades\DB;
use App\Services\ModelRepository;

class ActionRepository extends ModelRepository implements ActionRepositoryInterface
{
    protected $model;

    /**
     * @var string
     */
    protected $table = 'actions';

    /**
     * @var string
     */
    protected $tableTranslations = 'action_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'action_id';

    /**
     * Instances a new repository class
     * 
     * @param Action $model
     */
    public function __construct(Action $model)
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
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate, ['name', 'plural']);
    }

    /**
     *  Return Question type translations
     *
     */
    public function findByTranslated($where)
    {
        return $this->model
            ->where($where)
            ->orderBy('order', 'ASC')
            ->get();
    }
}
