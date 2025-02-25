<?php

namespace Modules\Sport\Repositories;

use Modules\Sport\Repositories\Interfaces\SportRepositoryInterface;
use Modules\Sport\Entities\Sport;
use App\Services\ModelRepository;
use Illuminate\Support\Facades\DB;

class SportRepository extends ModelRepository implements SportRepositoryInterface
{
    /** 
     * @var object
    */
    protected $model;

    /**
     * @var string
     */
    protected $table = 'sports';
    
    /**
     * @var string
     */
    protected $tableTranslations = 'sport_translations';
    
    /**
     * @var string
     */
    protected $fieldAssociate = 'sport_id';

    public function __construct(Sport $model)
    {
        $this->model = $model;

        parent::__construct($this->model);
    }

    /**
     * Returns the list of sports translated
     *
     * @var array
     */
    public function findAllTranslated()
    {
        return $this->findAllByLocale($this->table, $this->tableTranslations, $this->fieldAssociate);
    }

    /**
     * Updates the field_image attribute
     *
     * @return bool
     */
    public function updateFieldImage($code, $value)
    {
        return $this->model->where('code' , $code)->update(['field_image' => $value]);
    }

    /**
     * Returns the list of sport codes
     *
     * @return array
     */
    public function getSportCodes()
    {
        return $this->findAll()->map(function ($sport) {
            return $sport->code;
        });
    }

    /**
     * 
     */
    public function findByScouting($hasScouting)
    {
        $query = $this->model->where(
            'has_scouting', $hasScouting
        );

        return $query->get();
    }
}