<?php

namespace Modules\Generality\Repositories;

use App\Services\ModelRepository;
use Modules\Generality\Entities\Weather;
use Modules\Generality\Repositories\Interfaces\WeatherRepositoryInterface;

class WeatherRepository extends ModelRepository implements WeatherRepositoryInterface
{
    /**
     * @var object
    */
    protected $model;

    /**
     * @var string
    */
    protected $table = 'weathers';

    /**
     * @var string
    */
    protected $tableTranslations = 'weather_translations';

    /**
     * @var string
    */
    protected $fieldAssociate = 'weather_id';

    public function __construct(Weather $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }


}
