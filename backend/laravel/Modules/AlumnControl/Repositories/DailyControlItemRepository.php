<?php

namespace Modules\AlumnControl\Repositories;

use App\Services\ModelRepository;
use Modules\AlumnControl\Entities\DailyControlItem;
use Modules\AlumnControl\Repositories\Interfaces\DailyControlItemRepositoryInterface;

class DailyControlItemRepository extends ModelRepository implements DailyControlItemRepositoryInterface
{
    /**
     * @var string
     */
    protected $table = 'daily_control_items';

    /**
     * @var string
     */
    protected $tableTranslations = 'daily_control_items_translations';

    /**
     * @var string
     */
    protected $fieldAssociate = 'daily_control_item_id';

    /**
     * @var object
     */
    protected $model;

    /**
     * Creates a new Repository instance
     */
    public function __construct(DailyControlItem $model)
    {
        $this->model = $model;
        $this->relations = ['image'];

        parent::__construct($this->model, $this->relations);
    }

    /**
     *  Return a set of translated items
     *
     * @return array
     */
    public function findAllTranslated()
    {
        return $this->findAll();
    }
}
