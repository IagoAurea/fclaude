<?php

namespace Modules\Generality\Repositories;

use Modules\Generality\Repositories\Interfaces\WeekDayRepositoryInterface;
use Modules\Generality\Entities\WeekDay;
use App\Services\ModelRepository;

class WeekDayRepository extends ModelRepository implements WeekDayRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    /**
     * @var string
    */
    protected $table = 'week_days';

    /**
     * @var string
    */
    protected $tableTranslations = 'week_day_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'week_day_id';

    /**
     * Creates a new repository instance
     */
    public function __construct(WeekDay $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Retuns all items translated
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }
}
